<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlistIds = session()->get('wishlist', []);
        
        $products = collect();
        if (count($wishlistIds) > 0) {
            $products = Product::whereIn('id', $wishlistIds)->with(['category', 'brand', 'room', 'images'])->get();
        }

        return view('pages.wishlist', compact('products'));
    }

    public function add($id)
    {
        $product = Product::findOrFail($id);
        $wishlist = session()->get('wishlist', []);
        
        if (!in_array($id, $wishlist)) {
            $wishlist[] = $id;
            session()->put('wishlist', $wishlist);
            return back()->with('success', 'Product added to wishlist.');
        }

        return back()->with('info', 'Product is already in wishlist.');
    }

    public function remove($id)
    {
        $wishlist = session()->get('wishlist', []);
        
        if (($key = array_search($id, $wishlist)) !== false) {
            unset($wishlist[$key]);
            session()->put('wishlist', array_values($wishlist));
        }

        return back()->with('success', 'Product removed from wishlist.');
    }

    public function clear()
    {
        session()->forget('wishlist');
        return back()->with('success', 'Wishlist cleared.');
    }
}
