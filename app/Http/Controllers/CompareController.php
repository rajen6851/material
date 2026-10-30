<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CompareController extends Controller
{
    public function index()
    {
        $compareIds = session()->get('compare', []);
        
        $products = collect();
        if (count($compareIds) > 0) {
            $products = Product::whereIn('id', $compareIds)->with(['category', 'brand', 'room', 'images'])->get();
        }

        return view('pages.compare', compact('products'));
    }

    public function add(Request $request)
    {
        $productId = $request->input('product_id');
        $compare = session()->get('compare', []);
        
        if (!in_array($productId, $compare)) {
            // Limit comparison to 4 products max
            if (count($compare) >= 4) {
                return back()->with('error', 'You can only compare up to 4 products at a time.');
            }
            $compare[] = $productId;
            session()->put('compare', $compare);
            return back()->with('success', 'Product added to comparison.');
        }

        return back()->with('info', 'Product is already in comparison list.');
    }

    public function remove(Request $request)
    {
        $productId = $request->input('product_id');
        $compare = session()->get('compare', []);
        
        if (($key = array_search($productId, $compare)) !== false) {
            unset($compare[$key]);
            session()->put('compare', array_values($compare));
        }

        return back()->with('success', 'Product removed from comparison.');
    }

    public function clear()
    {
        session()->forget('compare');
        return back()->with('success', 'Comparison list cleared.');
    }
}
