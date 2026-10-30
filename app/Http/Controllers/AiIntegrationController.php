<?php

namespace App\Http\Controllers;

use App\Models\AiQuotation;
use App\Models\AiQuotationItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AiIntegrationController extends Controller
{
    /**
     * Web Chat Proxy.
     * Receives message from browser widget, adds session identifier,
     * forwards to Python FastAPI service on Render/localhost, and returns response.
     */
    public function chat(Request $request)
    {
        @set_time_limit(180);

        $request->validate([
            'message' => 'required|string|max:2000',
            'session_id' => 'nullable|string|max:128',
            'customer_context' => 'nullable|array',
        ]);

        $sessionId = $request->input('session_id')
            ?: ($request->hasSession() ? $request->session()->getId() : (string) \Illuminate\Support\Str::uuid());
        $fastApiUrl = config('services.ai.service_url', env('AI_SERVICE_URL', 'http://127.0.0.1:8001'));
        $secretKey = config('services.ai.secret_token', env('AI_SERVICE_SECRET', 'pristo_ai_secure_token_2026'));

        try {
            $response = Http::timeout(120)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $secretKey,
                    'Accept' => 'application/json',
                ])
                ->post(rtrim($fastApiUrl, '/') . '/chat', [
                    'session_id' => $sessionId,
                    'message' => $request->input('message'),
                    'channel' => 'website',
                    'customer_context' => (object)$request->input('customer_context', []),
                ]);

            if ($response->successful()) {
                return response()->json($response->json());
            }

            Log::error('AI Service Error', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return response()->json([
                'status' => 'error',
                'reply' => 'I apologize, but our sales assistant service is experiencing high traffic. Please try again or reach our team directly at +91 6362346660.',
                'products' => [],
            ], 502);

        } catch (\Exception $e) {
            Log::error('AI Service Connection Exception: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'reply' => 'We are having trouble connecting to our catalog engine. You can also chat directly with our sales team on WhatsApp at +91 6362346660.',
                'products' => [],
            ], 500);
        }
    }

    /**
     * Internal Products Catalog API (Read-Only).
     * Used by Python service for product search and as an authenticated fallback
     * when remote MySQL connectivity on shared hosting is restricted.
     */
    public function internalProducts(Request $request)
    {
        $this->verifyInternalToken($request);

        $query = Product::query()->with(['brand:id,name,slug', 'category:id,name,slug', 'images']);

        if ($request->filled('q')) {
            $q = trim($request->input('q'));
            $query->where(function ($b) use ($q) {
                $b->where('name', 'LIKE', "%{$q}%")
                  ->orWhere('sku', 'LIKE', "%{$q}%")
                  ->orWhere('description', 'LIKE', "%{$q}%")
                  ->orWhere('sub_category', 'LIKE', "%{$q}%")
                  ->orWhere('size', 'LIKE', "%{$q}%")
                  ->orWhere('material', 'LIKE', "%{$q}%")
                  ->orWhere('finish', 'LIKE', "%{$q}%");
            });
        }

        if ($request->filled('sku')) {
            $query->where('sku', $request->input('sku'));
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        if ($request->filled('category_slug')) {
            $slug = $request->input('category_slug');
            $query->whereHas('category', fn($c) => $c->where('slug', $slug));
        }

        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->input('brand_id'));
        }

        if ($request->filled('finish')) {
            $query->where('finish', 'LIKE', '%' . $request->input('finish') . '%');
        }

        if ($request->filled('material')) {
            $query->where('material', 'LIKE', '%' . $request->input('material') . '%');
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', (float)$request->input('min_price'));
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', (float)$request->input('max_price'));
        }

        if ($request->boolean('in_stock_only', false)) {
            $query->where('stock', '>', 0);
        }

        $limit = min((int)$request->input('limit', 20), 50);
        $products = $query->take($limit)->get();

        $baseUrl = config('app.url', 'https://pristoenterprises.in');

        $formatted = $products->map(function ($p) use ($baseUrl) {
            $primaryImg = $p->images->firstWhere('is_primary', true) ?: $p->images->first();
            $imgPath = $primaryImg ? $primaryImg->image_path : 'images/placeholder-product.jpg';
            $fullImgUrl = str_starts_with($imgPath, 'http') ? $imgPath : rtrim($baseUrl, '/') . '/' . ltrim($imgPath, '/');

            return [
                'id' => $p->id,
                'name' => $p->name,
                'slug' => $p->slug,
                'sku' => $p->sku,
                'mrp' => (float)$p->mrp,
                'price' => (float)$p->price,
                'price_per_box' => (float)$p->price_per_box,
                'pieces_per_box' => $p->pieces_per_box,
                'coverage_per_box_sqft' => (float)$p->coverage_per_box_sqft,
                'weight_per_box_kg' => (float)$p->weight_per_box_kg,
                'gst_percent' => (float)$p->gst_percent,
                'stock' => (int)$p->stock,
                'size' => $p->size,
                'finish' => $p->finish,
                'material' => $p->material,
                'category' => $p->category?->name,
                'brand' => $p->brand?->name,
                'sub_category' => $p->sub_category,
                'description' => $p->short_description ?: Str::limit(strip_tags($p->description), 200),
                'image_url' => $fullImgUrl,
                'product_url' => rtrim($baseUrl, '/') . '/products/' . $p->slug,
            ];
        });

        return response()->json([
            'status' => 'success',
            'count' => $formatted->count(),
            'products' => $formatted,
        ]);
    }

    /**
     * Create Draft Quotation.
     * Called by Python AI service when the customer confirms requirements.
     * Recalculates prices and taxes independently server-side and stores draft with 'draft_pending' status.
     */
    public function createDraftQuote(Request $request)
    {
        $this->verifyInternalToken($request);

        $request->validate([
            'channel' => 'required|string|in:website,whatsapp',
            'session_id' => 'nullable|string|max:128',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:32',
            'customer_email' => 'nullable|email|max:255',
            'customer_type' => 'nullable|string|in:homeowner,professional,builder,unknown',
            'delivery_address' => 'required|string',
            'pincode' => 'required|string|max:10',
            'customer_notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|integer|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_type' => 'nullable|string|in:box,piece,sqft',
        ]);

        return DB::transaction(function () use ($request) {
            $quoteNumber = AiQuotation::generateQuoteNumber();

            $subtotal = 0;
            $taxTotal = 0;
            $discountTotal = 0;
            $lineItems = [];

            foreach ($request->input('items') as $reqItem) {
                $product = Product::lockForUpdate()->findOrFail($reqItem['product_id']);
                $qty = (int)$reqItem['quantity'];
                $unitType = $reqItem['unit_type'] ?? ($product->pieces_per_box ? 'box' : 'piece');

                // Determine base unit price
                $unitPrice = (float)$product->price;
                if ($unitType === 'box' && $product->price_per_box > 0) {
                    $unitPrice = (float)$product->price_per_box;
                }

                $itemTotal = $unitPrice * $qty;
                $subtotal += $itemTotal;

                // GST included in price: Total - (Total / (1 + gst_percent/100))
                $gstRate = (float)($product->gst_percent ?: 18.00);
                $taxComponent = $itemTotal - ($itemTotal / (1 + ($gstRate / 100)));
                $taxTotal += $taxComponent;

                $lineItems[] = [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'sku' => $product->sku,
                    'unit_type' => $unitType,
                    'unit_price' => $unitPrice,
                    'quantity' => $qty,
                    'gst_percent' => $gstRate,
                    'total_price' => $itemTotal,
                ];
            }

            $grandTotal = max(0, $subtotal - $discountTotal);

            $quotation = AiQuotation::create([
                'quote_number' => $quoteNumber,
                'channel' => $request->input('channel'),
                'session_id' => $request->input('session_id'),
                'customer_name' => $request->input('customer_name'),
                'customer_phone' => $request->input('customer_phone'),
                'customer_email' => $request->input('customer_email'),
                'customer_type' => $request->input('customer_type', 'homeowner'),
                'delivery_address' => $request->input('delivery_address'),
                'pincode' => $request->input('pincode'),
                'subtotal' => $subtotal,
                'tax_total' => $taxTotal,
                'discount_total' => $discountTotal,
                'grand_total' => $grandTotal,
                'customer_notes' => $request->input('customer_notes'),
                'status' => 'draft_pending',
                'dispatch_status' => 'pending',
            ]);

            foreach ($lineItems as $item) {
                $item['ai_quotation_id'] = $quotation->id;
                AiQuotationItem::create($item);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Quotation draft created successfully and submitted to admin panel for authorized review.',
                'quote_number' => $quotation->quote_number,
                'id' => $quotation->id,
                'subtotal' => $quotation->subtotal,
                'tax_total' => $quotation->tax_total,
                'grand_total' => $quotation->grand_total,
                'status' => $quotation->status,
            ], 201);
        });
    }

    /**
     * Check if Bearer token matches the internal AI service secret.
     */
    private function verifyInternalToken(Request $request): void
    {
        $token = $request->bearerToken();
        $expectedToken = config('services.ai.secret_token', env('AI_SERVICE_SECRET', 'pristo_ai_secure_token_2026'));

        if (!$token || !hash_equals($expectedToken, $token)) {
            abort(response()->json(['error' => 'Unauthorized: Invalid AI service credentials.'], 401));
        }
    }
}
