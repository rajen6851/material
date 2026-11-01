<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\PackageItem;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Routing\Controllers\HasMiddleware;

class PackageController extends Controller implements HasMiddleware
{
    /**
     * Admin auth check middleware.
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
     * Display a listing of packages.
     */
    public function index(Request $request)
    {
        $query = Package::with(['brand', 'items'])->orderBy('sort_order', 'asc')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('tagline', 'like', "%{$search}%");
            });
        }

        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }

        $packages = $query->paginate(15)->withQueryString();
        $brands = Brand::orderBy('name')->get();

        return view('admin.packages.index', compact('packages', 'brands'));
    }

    /**
     * Show form for creating a new package.
     */
    public function create()
    {
        $brands = Brand::orderBy('name')->get();
        return view('admin.packages.create', compact('brands'));
    }

    /**
     * Store a newly created package.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'brand_id' => 'nullable|exists:brands,id',
            'tagline' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'mrp' => 'nullable|numeric|min:0',
            'sort_order' => 'nullable|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:4096',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $image->getClientOriginalExtension();
            $dest = public_path('images/packages');
            if (!File::isDirectory($dest)) {
                File::makeDirectory($dest, 0755, true, true);
            }
            $image->move($dest, $imageName);
            $imagePath = 'images/packages/' . $imageName;
        }

        $slug = Str::slug($request->name);
        $originalSlug = $slug;
        $counter = 1;
        while (Package::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }

        $package = Package::create([
            'name' => $request->name,
            'slug' => $slug,
            'brand_id' => $request->brand_id,
            'tagline' => $request->tagline,
            'description' => $request->description,
            'price' => $request->price,
            'mrp' => $request->mrp,
            'image' => $imagePath,
            'is_active' => $request->has('is_active'),
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()->route('admin.packages.edit', $package->id)
            ->with('success', 'Package created successfully! You can now add Basin, WC, and Shower items.');
    }

    /**
     * Edit package details and manage items.
     */
    public function edit($id)
    {
        $package = Package::with(['brand', 'items.product'])->findOrFail($id);
        $brands = Brand::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();
        
        // All items ordered by sort_order
        $items = $package->items;

        // Sample initial products for quick selection
        $existingProducts = Product::with('images')
            ->select('id', 'name', 'sku', 'price', 'mrp', 'category_id', 'brand_id', 'short_description')
            ->latest()
            ->limit(50)
            ->get();

        return view('admin.packages.edit', compact('package', 'brands', 'categories', 'items', 'existingProducts'));
    }

    /**
     * Update package details.
     */
    public function update(Request $request, $id)
    {
        $package = Package::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'brand_id' => 'nullable|exists:brands,id',
            'tagline' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'mrp' => 'nullable|numeric|min:0',
            'sort_order' => 'nullable|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:4096',
        ]);

        $imagePath = $package->image;
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($package->image && File::exists(public_path($package->image))) {
                File::delete(public_path($package->image));
            }

            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $image->getClientOriginalExtension();
            $dest = public_path('images/packages');
            if (!File::isDirectory($dest)) {
                File::makeDirectory($dest, 0755, true, true);
            }
            $image->move($dest, $imageName);
            $imagePath = 'images/packages/' . $imageName;
        }

        $package->update([
            'name' => $request->name,
            'brand_id' => $request->brand_id,
            'tagline' => $request->tagline,
            'description' => $request->description,
            'price' => $request->price,
            'mrp' => $request->mrp,
            'image' => $imagePath,
            'is_active' => $request->has('is_active'),
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()->route('admin.packages.edit', $package->id)->with('success', 'Package details updated successfully.');
    }

    /**
     * Toggle active status.
     */
    public function toggle($id)
    {
        $package = Package::findOrFail($id);
        $package->is_active = !$package->is_active;
        $package->save();

        return back()->with('success', 'Package status updated to ' . ($package->is_active ? 'Active' : 'Inactive'));
    }

    /**
     * Delete package and associated items.
     */
    public function destroy($id)
    {
        $package = Package::with('items')->findOrFail($id);

        if ($package->image && File::exists(public_path($package->image))) {
            File::delete(public_path($package->image));
        }

        foreach ($package->items as $item) {
            if ($item->image && Str::startsWith($item->image, 'images/packages/') && File::exists(public_path($item->image))) {
                File::delete(public_path($item->image));
            }
        }

        $package->delete();

        return redirect()->route('admin.packages.index')->with('success', 'Package deleted successfully.');
    }

    /**
     * Add item to package.
     */
    public function storeItem(Request $request, $packageId)
    {
        $package = Package::findOrFail($packageId);

        $request->validate([
            'name' => 'required|string|max:255',
            'area' => 'nullable|string|max:100',
            'cat_no' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'quantity' => 'nullable|integer|min:1',
            'sort_order' => 'nullable|integer',
            'product_id' => 'nullable|exists:products,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:4096',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $image->getClientOriginalExtension();
            $dest = public_path('images/packages/items');
            if (!File::isDirectory($dest)) {
                File::makeDirectory($dest, 0755, true, true);
            }
            $image->move($dest, $imageName);
            $imagePath = 'images/packages/items/' . $imageName;
        } elseif ($request->filled('product_id')) {
            $product = Product::with('images')->find($request->product_id);
            if ($product) {
                $imagePath = $product->featured_image;
            }
        }

        PackageItem::create([
            'package_id' => $package->id,
            'area' => $request->area ?: 'Basin Area',
            'product_id' => $request->product_id,
            'cat_no' => $request->cat_no,
            'name' => $request->name,
            'description' => $request->description,
            'image' => $imagePath,
            'price' => $request->price,
            'quantity' => $request->quantity ?? 1,
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()->route('admin.packages.edit', $package->id)
            ->with('success', 'Product added to package successfully!');
    }

    /**
     * Update an item in a package.
     */
    public function updateItem(Request $request, $itemId)
    {
        $item = PackageItem::findOrFail($itemId);

        $request->validate([
            'name' => 'required|string|max:255',
            'area' => 'nullable|string|max:100',
            'cat_no' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'quantity' => 'nullable|integer|min:1',
            'sort_order' => 'nullable|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:4096',
        ]);

        $imagePath = $item->image;
        if ($request->hasFile('image')) {
            if ($item->image && Str::startsWith($item->image, 'images/packages/') && File::exists(public_path($item->image))) {
                File::delete(public_path($item->image));
            }

            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $image->getClientOriginalExtension();
            $dest = public_path('images/packages/items');
            if (!File::isDirectory($dest)) {
                File::makeDirectory($dest, 0755, true, true);
            }
            $image->move($dest, $imageName);
            $imagePath = 'images/packages/items/' . $imageName;
        }

        $item->update([
            'name' => $request->name,
            'area' => $request->area ?: ($item->area ?: 'Basin Area'),
            'cat_no' => $request->cat_no,
            'description' => $request->description,
            'image' => $imagePath,
            'price' => $request->price,
            'quantity' => $request->quantity ?? 1,
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()->route('admin.packages.edit', $item->package_id)
            ->with('success', 'Product updated successfully!');
    }

    /**
     * Quickly update item area (inline from dropdown).
     */
    public function updateItemArea(Request $request, $itemId)
    {
        $item = PackageItem::findOrFail($itemId);

        $request->validate([
            'area' => 'required|string|max:100',
        ]);

        $item->update([
            'area' => $request->area,
        ]);

        return back()->with('success', "'{$item->name}' moved to {$item->area}.");
    }

    /**
     * Delete an item from a package.
     */
    public function destroyItem($itemId)
    {
        $item = PackageItem::findOrFail($itemId);
        $packageId = $item->package_id;

        if ($item->image && Str::startsWith($item->image, 'images/packages/') && File::exists(public_path($item->image))) {
            File::delete(public_path($item->image));
        }

        $item->delete();

        return redirect()->route('admin.packages.edit', $packageId)->with('success', 'Product removed successfully.');
    }

    /**
     * Bulk add existing products to a package.
     */
    public function bulkAddProducts(Request $request, $packageId)
    {
        $package = Package::findOrFail($packageId);

        $request->validate([
            'product_ids' => 'required|array|min:1',
            'product_ids.*' => 'exists:products,id',
            'area' => 'nullable|string|max:100',
        ]);

        $area = $request->area ?: 'Basin Area';

        $products = Product::whereIn('id', $request->product_ids)->get();

        $lastSort = PackageItem::where('package_id', $package->id)->max('sort_order') ?? 0;

        foreach ($products as $index => $product) {
            PackageItem::create([
                'package_id' => $package->id,
                'area' => $area,
                'product_id' => $product->id,
                'cat_no' => $product->sku,
                'name' => $product->name,
                'description' => $product->short_description ?? ($product->name . ' - ' . ($product->brand ? $product->brand->name : '')),
                'image' => $product->featured_image,
                'price' => $product->price,
                'quantity' => 1,
                'sort_order' => $lastSort + $index + 1,
            ]);
        }

        return redirect()->route('admin.packages.edit', $package->id)
            ->with('success', count($products) . " product(s) added to {$area} successfully!");
    }

    /**
     * Search products API for quick picker.
     */
    public function searchProducts(Request $request)
    {
        $term = trim($request->get('q', ''));
        $categoryId = $request->get('category_id');
        $brandId = $request->get('brand_id');

        $query = Product::with(['images', 'brand', 'category']);

        if (strlen($term) > 0) {
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                  ->orWhere('sku', 'like', "%{$term}%");
            });
        }

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        if ($brandId) {
            $query->where('brand_id', $brandId);
        }

        $products = $query->latest()->limit(30)->get();

        $results = $products->map(function ($p) {
            return [
                'id' => $p->id,
                'name' => $p->name,
                'sku' => $p->sku,
                'price' => $p->price,
                'mrp' => $p->mrp,
                'brand_name' => $p->brand ? $p->brand->name : '',
                'category_name' => $p->category ? $p->category->name : '',
                'description' => $p->short_description ?? '',
                'image' => $p->featured_image ? asset($p->featured_image) : null,
                'raw_image' => $p->featured_image,
            ];
        });

        return response()->json($results);
    }
}

