<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\QuotationRequest;
use App\Models\ShowroomVisit;
use App\Models\Address;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Customer Dashboard Index.
     */
    public function index()
    {
        $userId = auth()->id();
        $orders = Order::where('user_id', $userId)->orderBy('created_at', 'desc')->get();
        $quotations = QuotationRequest::where('user_id', $userId)->with('product')->orderBy('created_at', 'desc')->get();
        $visits = ShowroomVisit::where('user_id', $userId)->orderBy('created_at', 'desc')->get();
        $addresses = Address::where('user_id', $userId)->get();

        return view('dashboard', compact('orders', 'quotations', 'visits', 'addresses'));
    }

    /**
     * Quotation Request Form.
     */
    public function createQuotation(Request $request)
    {
        $productId = $request->input('product_id');
        $selectedProduct = $productId ? Product::find($productId) : null;
        $products = Product::all();

        return view('dashboard.create-quotation', compact('products', 'selectedProduct'));
    }

    /**
     * Store Quotation Request.
     */
    public function storeQuotation(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'address' => 'required|string',
            'remarks' => 'nullable|string'
        ]);

        QuotationRequest::create([
            'user_id' => auth()->id(),
            'product_id' => $request->input('product_id'),
            'quantity' => $request->input('quantity'),
            'address' => $request->input('address'),
            'remarks' => $request->input('remarks'),
            'status' => 'pending'
        ]);

        return redirect()->route('dashboard')->with('success', 'Quotation request submitted successfully! An admin will respond shortly.');
    }

    /**
     * Showroom Visit Booking Form.
     */
    public function bookShowroomForm()
    {
        return view('dashboard.book-showroom');
    }

    /**
     * Store Showroom Visit Booking.
     */
    public function bookShowroom(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:15',
            'visit_date' => 'required|date|after_or_equal:today',
            'visit_time' => 'required|string',
            'purpose' => 'nullable|string|in:inspect,browse,purchase,consultation,trade',
        ]);

        $role = auth()->check() ? auth()->user()->role : 'homeowner';
        $purpose = $request->input('purpose');

        // Tailor the default purpose to the visitor role.
        if (! $purpose) {
            $purpose = $role === 'professional' ? 'trade' : 'purchase';
        }

        ShowroomVisit::create([
            'user_id' => auth()->check() ? auth()->id() : null,
            'name' => $request->input('name'),
            'mobile' => $request->input('mobile'),
            'role' => $role,
            'purpose' => $purpose,
            'visit_date' => $request->input('visit_date'),
            'visit_time' => $request->input('visit_time'),
            'status' => 'pending'
        ]);

        return redirect()->route(auth()->check() ? 'dashboard' : 'products.index')
            ->with('success', 'Showroom visit booked! We will call you to confirm.');
    }
}
