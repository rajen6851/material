<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
    public function show(Category $category)
    {
        $subCategories = $category->subCategories()->get();

        $counts = Product::whereNotNull('sub_category')
            ->selectRaw('sub_category, count(*) as total')
            ->groupBy('sub_category')
            ->pluck('total', 'sub_category');

        return view('categories.show', compact('category', 'subCategories', 'counts'));
    }
}
