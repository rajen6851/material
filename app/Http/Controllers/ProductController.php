<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Room;
use App\Models\Brand;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        $query = Product::query()->with([
            'category',
            'rooms',
            'brand',
            'images'
        ])
            ->where('stock', '>', 0);


        // =========================
        // Search filter
        // =========================
        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // =========================
        // Category filter
        // =========================
        $selectedCategoryName = null;

        if ($request->filled('category')) {

            $categorySlug = $request->input('category');

            $selectedCategory = Category::where('slug', $categorySlug)->first();

            if ($selectedCategory) {
                $selectedCategoryName = $selectedCategory->name;
            }

            $query->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        // =========================
        // Subcategory filter
        // =========================
        $selectedSubCategoryName = null;

        if ($request->filled('subcategory')) {

            $subInput = $request->input('subcategory');

            $subcat = SubCategory::where('slug', $subInput)->first();

            if ($subcat) {

                $query->where(function ($q) use ($subcat) {
                    $q->where('sub_category', $subcat->name)
                        ->orWhere(
                            'sub_category',
                            'like',
                            '%' . $subcat->name . '%'
                        );
                });

                $selectedSubCategoryName = $subcat->name;

            } else {

                $cleanSub = str_replace('-', ' ', $subInput);

                $query->where(function ($q) use ($subInput, $cleanSub) {
                    $q->where('sub_category', $subInput)
                        ->orWhere('sub_category', $cleanSub)
                        ->orWhere(
                            'sub_category',
                            'like',
                            '%' . $cleanSub . '%'
                        );
                });

                $selectedSubCategoryName = ucwords($cleanSub);
            }
        }

        // =========================
        // Room filter
        // =========================
       // =========================
// Room filter
// =========================
if ($request->filled('room')) {

    $roomSlug = $request->input('room');

    $query->whereHas('rooms', function ($q) use ($roomSlug) {
        $q->where('slug', $roomSlug);
    });
}

        // =========================
        // Brand filter
        // =========================
        if ($request->filled('brand')) {

            $brandSlug = $request->input('brand');

            $query->whereHas('brand', function ($q) use ($brandSlug) {
                $q->where('slug', $brandSlug);
            });
        }

        // =========================
        // Finish filter
        // =========================
        if ($request->filled('finish')) {
            $query->where('finish', $request->input('finish'));
        }

        // =========================
        // Material filter
        // =========================
        if ($request->filled('material')) {
            $query->where('material', $request->input('material'));
        }

        // =========================
        // Color filter
        // =========================
        if ($request->filled('color')) {
            $query->where('color', $request->input('color'));
        }

        // =========================
        // Size filter
        // =========================
        if ($request->filled('size')) {
            $query->where('size', $request->input('size'));
        }

        // =========================
        // FEATURED FILTER
        // =========================
        if ($request->filled('featured')) {
            $query->where('is_featured', $request->input('featured'));
        }

        // =========================
        // TRENDING FILTER
        // =========================
        if ($request->filled('trending')) {
            $query->where('is_trending', $request->input('trending'));
        }

        // =========================
        // NEW PRODUCT FILTER
        // =========================
        if ($request->filled('new')) {
            $query->where('is_new', $request->input('new'));
        }

        // =========================
        // Price range filter
        // =========================
        if ($request->filled('price_range')) {

            $priceRange = $request->input('price_range');

            switch ($priceRange) {

                case 'under-1000':

                    $query->where('price', '<', 1000);

                    break;

                case 'above-5000':

                    $query->where('price', '>=', 5000);

                    break;

                default:

                    if (
                        preg_match(
                            '/^(\d+)-(\d+)$/',
                            $priceRange,
                            $matches
                        )
                    ) {

                        $query->whereBetween('price', [
                            (float) $matches[1],
                            (float) $matches[2]
                        ]);
                    }

                    break;
            }
        }

        // =========================
        // Minimum price
        // =========================
        if ($request->filled('min_price')) {

            $query->where(
                'price',
                '>=',
                $request->input('min_price')
            );
        }

        // =========================
        // Maximum price
        // =========================
        if ($request->filled('max_price')) {

            $query->where(
                'price',
                '<=',
                $request->input('max_price')
            );
        }

        // =========================
        // Sorting
        // =========================
        // $sort = $request->input('sort', 'default');

        // if ($sort === 'price_asc') {

        //     $query->orderBy('price', 'asc');

        // } elseif ($sort === 'price_desc') {

        //     $query->orderBy('price', 'desc');

        // } elseif ($sort === 'rating') {

        //     $query->orderBy('rating', 'desc');

        // } else {

        //     $query->orderBy('created_at', 'desc');
        // }
        $sort = $request->input('sort', 'price_asc');

if ($sort === 'price_desc') {
    $query->orderBy('price', 'desc');
} elseif ($sort === 'rating') {
    $query->orderBy('rating', 'desc');
} else {
    // Default: lowest price to highest price
    $query->orderBy('price', 'asc');
}

        // =========================
        // Pagination
        // =========================
        $products = $query
            ->paginate(24)
            ->withQueryString();

        // =========================
        // Filter options
        // =========================
        $categories = Category::all();

        $rooms = Room::all();

        $brands = Brand::all();

        $finishes = Product::whereNotNull('finish')
            ->distinct()
            ->pluck('finish');

        $materials = Product::whereNotNull('material')
            ->distinct()
            ->pluck('material');

        $colors = Product::whereNotNull('color')
            ->distinct()
            ->pluck('color');

        $sizes = Product::whereNotNull('size')
            ->distinct()
            ->pluck('size');

        // =========================
        // Subcategories
        // =========================
        $subCategories = collect();

        if ($request->filled('category')) {

            $categorySlug = $request->input('category');

            $selectedCategory = Category::where(
                'slug',
                $categorySlug
            )->first();

            if ($selectedCategory) {

                $subCategories = $selectedCategory->subCategories;
            }
        }

        // =========================
        // Return view
        // =========================
        return view('products.index', compact(
            'products',
            'categories',
            'rooms',
            'brands',
            'finishes',
            'materials',
            'colors',
            'sizes',
            'subCategories',
            'selectedCategoryName',
            'selectedSubCategoryName'
        ));
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)->with(['category', 'rooms', 'brand', 'images'])->firstOrFail();

        $relatedProducts = $product->relatedProducts()->with(['category', 'brand', 'images'])->take(4)->get();
        
        if ($relatedProducts->isEmpty()) {
            $relatedProducts = Product::where('category_id', $product->category_id)
                ->where('id', '!=', $product->id)
                ->take(4)
                ->get();
        }

        return view('products.show', compact('product', 'relatedProducts'));
    }
}
