<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     * Supports optional filtering by category, brand, room, or search query.
     */
    public function index(Request $request)
    {
        $query = Product::query();

        // Filter by category slug
        if ($category = $request->query('category')) {
            $query->whereHas('category', function ($q) use ($category) {
                $q->where('slug', $category);
            });
        }

        // Filter by brand slug
        if ($brand = $request->query('brand')) {
            $query->whereHas('brand', function ($q) use ($brand) {
                $q->where('slug', $brand);
            });
        }

        // Filter by room slug (assuming a many‑to‑many relationship "rooms")
        if ($room = $request->query('room')) {
            $query->whereHas('rooms', function ($q) use ($room) {
                $q->where('slug', $room);
            });
        }

        // Simple search across product name
        if ($search = $request->query('search')) {
            $query->where('name', 'like', "%{$search}%");
        }

        $products = $query->paginate(12);

        return view('products.index', compact('products'));
    }

    /**
     * Show the detail page for a single product.
     */
    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        return view('products.show', compact('product'));
    }
}
