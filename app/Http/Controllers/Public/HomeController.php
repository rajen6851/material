<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Show the homepage.
     *
     * For now we reuse the existing welcome view.
     */
    public function index()
    {
        $banners = \App\Models\Banner::where('is_active', true)->get();
        $rooms = \App\Models\Room::all();
        $categories = \App\Models\Category::all();
        $brands = \App\Models\Brand::all();
        $featuredProducts = \App\Models\Product::where('is_featured', true)->take(8)->get();
        $newProducts = \App\Models\Product::where('is_new', true)->take(8)->get();
        return view('welcome', compact('banners', 'rooms', 'categories', 'brands', 'featuredProducts', 'newProducts'));
    }
}
