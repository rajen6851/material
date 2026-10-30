<?php

namespace App\Http\Controllers;

use App\Models\AiQuotation;
use App\Models\AiQuotationItem;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiQuotationAdminController extends Controller implements HasMiddleware
{
    /**
     * Enforce administrator access.
     */
    public static function middleware(): array
    {
        return [
            function ($request, $next) {
                if (!auth()->check() || !auth()->user()->isAdmin()) {
                    return redirect('/')->with('error', 'Access denied. Administrator privileges required.');
                }
                return $next($request);
            }
        ];
    }

    /**
     * List all AI Quotation drafts and submitted quotes.
     */
    public function index(Request $request)
    {
        $status = $request->input('status', 'all');
        $channel = $request->input('channel', 'all');

        $query = AiQuotation::with(['items.product', 'approvedBy'])
            ->orderBy('created_at', 'desc');

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        if ($channel !== 'all') {
            $query->where('channel', $channel);
        }

        $quotations = $query->paginate(20);

        $counts = [
            'all' => AiQuotation::count(),
            'draft_pending' => AiQuotation::where('status', 'draft_pending')->count(),
            'approved' => AiQuotation::where('status', 'approved')->count(),
            'rejected' => AiQuotation::where('status', 'rejected')->count(),
            'sent' => AiQuotation::where('status', 'sent')->count(),
        ];

        return view('admin.ai-quotes.index', compact('quotations', 'counts', 'status', 'channel'));
    }

    /**
     * Detailed inspection view for a single AI quotation.
     */
    public function show($id)
    {
        $quote = AiQuotation::with(['items.product', 'approvedBy'])->findOrFail($id);
        return view('admin.ai-quotes.show', compact('quote'));
    }

    /**
     * Approve quotation draft with optional adjusted pricing/discount.
     * Enforces that only authorized admin staff can approve.
     */
    public function approve(Request $request, $id)
    {
        $request->validate([
            'discount_total' => 'nullable|numeric|min:0',
            'admin_notes' => 'nullable|string|max:1000',
            'item_prices' => 'nullable|array',
            'item_prices.*' => 'numeric|min:0',
        ]);

        $quote = AiQuotation::with('items')->findOrFail($id);

        if ($quote->status === 'sent') {
            return redirect()->back()->with('error', 'This quotation has already been sent to the customer.');
        }

        DB::transaction(function () use ($request, $quote) {
            $subtotal = 0;
            $taxTotal = 0;

            if ($request->has('item_prices')) {
                foreach ($quote->items as $item) {
                    if (isset($request->item_prices[$item->id])) {
                        $newPrice = (float)$request->item_prices[$item->id];
                        $itemTotal = $newPrice * $item->quantity;
                        $tax = $itemTotal - ($itemTotal / (1 + ($item->gst_percent / 100)));

                        $item->update([
                            'unit_price' => $newPrice,
                            'total_price' => $itemTotal,
                        ]);

                        $subtotal += $itemTotal;
                        $taxTotal += $tax;
                    } else {
                        $subtotal += $item->total_price;
                        $taxTotal += $item->total_price - ($item->total_price / (1 + ($item->gst_percent / 100)));
                    }
                }
            } else {
                $subtotal = $quote->subtotal;
                $taxTotal = $quote->tax_total;
            }

            $discount = (float)$request->input('discount_total', $quote->discount_total);
            $grandTotal = max(0, $subtotal - $discount);

            $quote->update([
                'subtotal' => $subtotal,
                'tax_total' => $taxTotal,
                'discount_total' => $discount,
                'grand_total' => $grandTotal,
                'admin_notes' => $request->input('admin_notes', $quote->admin_notes),
                'status' => 'approved',
                'approved_by_user_id' => auth()->id(),
                'approved_at' => now(),
            ]);
        });

        return redirect()->route('admin.ai-quotes.show', $quote->id)
            ->with('success', "Quotation #{$quote->quote_number} approved successfully. You may now dispatch it to the customer.");
    }

    /**
     * Reject quotation draft with a reason.
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);

        $quote = AiQuotation::findOrFail($id);

        $quote->update([
            'status' => 'rejected',
            'rejection_reason' => $request->input('rejection_reason'),
            'approved_by_user_id' => auth()->id(),
            'approved_at' => now(),
        ]);

        return redirect()->route('admin.ai-quotes.show', $quote->id)
            ->with('info', "Quotation #{$quote->quote_number} has been rejected.");
    }

    /**
     * Dispatch approved quotation to customer via WhatsApp or Email.
     * Guaranteed security constraint: Never allows sending unapproved quotations.
     */
    public function send(Request $request, $id)
    {
        $quote = AiQuotation::with('items')->findOrFail($id);

        if ($quote->status !== 'approved') {
            return redirect()->back()->with('error', 'Security Violation: Quotation must be authorized and approved before sending to customer.');
        }

        try {
            // Forward dispatch instruction to Python WhatsApp handler if customer is on WhatsApp
            $fastApiUrl = config('services.ai.service_url', env('AI_SERVICE_URL', 'http://127.0.0.1:8000'));
            $secretKey = config('services.ai.secret_token', env('AI_SERVICE_SECRET', 'pristo_ai_secure_token_2026'));

            $response = Http::timeout(15)
                ->withHeaders(['Authorization' => 'Bearer ' . $secretKey])
                ->post(rtrim($fastApiUrl, '/') . '/whatsapp/send-quote', [
                    'quote_id' => $quote->id,
                    'quote_number' => $quote->quote_number,
                    'phone' => $quote->customer_phone,
                    'customer_name' => $quote->customer_name,
                    'grand_total' => (float)$quote->grand_total,
                    'items_summary' => $quote->items->map(fn($i) => "{$i->quantity}x {$i->product_name} ({$i->sku}) - ₹" . number_format($i->total_price, 2))->toArray(),
                ]);

            $dispatchPayload = [
                'dispatched_by' => auth()->user()->name,
                'dispatched_at' => now()->toIso8601String(),
                'response' => $response->successful() ? $response->json() : ['raw' => $response->body()],
            ];

            $quote->update([
                'status' => 'sent',
                'dispatch_status' => $response->successful() ? 'dispatched_successfully' : 'dispatch_attempted',
                'dispatch_payload' => $dispatchPayload,
            ]);

            return redirect()->route('admin.ai-quotes.show', $quote->id)
                ->with('success', "Quotation #{$quote->quote_number} has been officially dispatched to {$quote->customer_phone}!");

        } catch (\Exception $e) {
            Log::error('Dispatch error: ' . $e->getMessage());

            // Mark status but record error for audit
            $quote->update([
                'dispatch_status' => 'dispatch_failed: ' . $e->getMessage(),
            ]);

            return redirect()->route('admin.ai-quotes.show', $quote->id)
                ->with('warning', "Quotation was marked approved, but dispatch service reported: " . $e->getMessage());
        }
    }
}
