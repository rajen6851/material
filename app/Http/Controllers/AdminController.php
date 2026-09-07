<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\QuotationRequest;
use App\Models\ShowroomVisit;
use App\Models\Product;
use App\Models\Category;
use App\Models\Room;
use App\Models\Brand;
use App\Models\Banner;
use App\Models\ProductImage;
use App\Models\ProductAttribute;
use App\Models\SubCategory;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Routing\Controllers\HasMiddleware;

class AdminController extends Controller implements HasMiddleware
{
    /**
     * Protect all admin routes using inline middleware check.
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
     * Admin Dashboard Index.
     */
    public function index()
    {
        $totalRevenue = Order::where('payment_status', 'paid')->sum('total');
        $totalOrdersCount = Order::count();
        $pendingQuotationsCount = QuotationRequest::where('status', 'pending')->count();
        $pendingVisitsCount = ShowroomVisit::where('status', 'pending')->count();

        $recentOrders = Order::orderBy('created_at', 'desc')->take(5)->get();
        $recentQuotations = QuotationRequest::with(['user', 'product'])->orderBy('created_at', 'desc')->take(5)->get();
        $recentVisits = ShowroomVisit::orderBy('created_at', 'desc')->take(5)->get();

        return view('admin.dashboard', compact(
            'totalRevenue', 'totalOrdersCount', 'pendingQuotationsCount', 'pendingVisitsCount',
            'recentOrders', 'recentQuotations', 'recentVisits'
        ));
    }

    /**
     * Manage Orders.
     */
    public function orders()
    {
        $orders = Order::orderBy('created_at', 'desc')->get();
        return view('admin.orders', compact('orders'));
    }

    /**
     * Update Order Status.
     */
    public function updateOrderStatus(Request $request, $id)
    {
        $request->validate([
            'order_status' => 'required|string|in:pending,packed,shipped,delivered,cancelled',
            'payment_status' => 'required|string|in:pending,paid,failed,refunded'
        ]);

        $order = Order::findOrFail($id);
        $order->update([
            'order_status' => $request->input('order_status'),
            'payment_status' => $request->input('payment_status')
        ]);

        return redirect()->back()->with('success', 'Order status updated successfully.');
    }

    /**
     * Manage Quotations.
     */
    public function quotations()
    {
        $quotations = QuotationRequest::with(['user', 'product'])->orderBy('created_at', 'desc')->get();
        return view('admin.quotations', compact('quotations'));
    }

    /**
     * Respond to Quotation.
     */
    public function respondQuotation(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:approved,rejected',
            'proposed_price' => 'required_if:status,approved|nullable|numeric|min:0',
            'admin_remarks' => 'nullable|string'
        ]);

        $quote = QuotationRequest::findOrFail($id);
        $quote->update([
            'status' => $request->input('status'),
            'proposed_price' => $request->input('proposed_price'),
            'admin_remarks' => $request->input('admin_remarks')
        ]);

        return redirect()->back()->with('success', 'Quotation request updated successfully.');
    }

    /**
     * Manage Showroom Visits.
     */
    public function visits()
    {
        $visits = ShowroomVisit::orderBy('created_at', 'desc')->get();
        return view('admin.visits', compact('visits'));
    }

    /**
     * Update Showroom Visit Status.
     */
    public function updateVisitStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:pending,confirmed,completed,cancelled'
        ]);

        $visit = ShowroomVisit::findOrFail($id);
        $visit->update([
            'status' => $request->input('status')
        ]);

        return redirect()->back()->with('success', 'Showroom visit status updated successfully.');
    }

    /* -------------------------------------------------------------
     * CRUD: PRODUCTS
     * ------------------------------------------------------------- */

    public function products()
    {
        $products = Product::with(['category', 'room', 'brand'])->orderBy('created_at', 'desc')->get();
        return view('admin.products.index', compact('products'));
    }

    public function productCreate()
    {
        $categories = Category::with('subCategories')->get();
        $rooms = Room::all();
        $brands = Brand::all();
        $attributes = ProductAttribute::getAllGrouped();
        $subCategories = SubCategory::orderBy('sort_order')->get();
        return view('admin.products.create', compact('categories', 'rooms', 'brands', 'attributes', 'subCategories'));
    }

    public function productStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:products,sku',
            'mrp' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'room_id' => 'required|exists:rooms,id',
            'brand_id' => 'required|exists:brands,id',
            'image' => 'nullable|image|max:2048'
        ]);

        $slug = Str::slug($request->input('name'));

        // Handle image upload
        $imagePath = 'images/products/product1a.svg'; // fallback default
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/products'), $fileName);
            $imagePath = 'images/products/' . $fileName;
        }

        $product = Product::create([
            'name' => $request->input('name'),
            'slug' => $slug,
            'sku' => $request->input('sku'),
            'description' => $request->input('description'),
            'short_description' => $request->input('short_description'),
            'mrp' => $request->input('mrp'),
            'price' => $request->input('price'),
            'discount' => max(0, $request->input('mrp') - $request->input('price')),
            'stock' => $request->input('stock'),
            'category_id' => $request->input('category_id'),
            'room_id' => $request->input('room_id'),
            'brand_id' => $request->input('brand_id'),
            // Specs
            'size' => $request->input('size', '600x600 mm'),
            'color' => $request->input('color'),
            'finish' => $request->input('finish', 'Glossy'),
            'material' => $request->input('material', 'Ceramic'),
            'thickness' => $request->input('thickness', '9 mm'),
            'coverage_area' => $request->input('coverage_area'),
            'water_absorption' => $request->input('water_absorption'),
            'warranty' => $request->input('warranty'),
            'delivery_time' => $request->input('delivery_time'),
            'gst_percent' => $request->input('gst_percent', 18),
            // Spreadsheet fields
            'collection' => $request->input('collection'),
            'sub_category' => $request->input('sub_category'),
            'width_mm' => $request->input('width_mm'),
            'height_mm' => $request->input('height_mm'),
            'size_inch' => $request->input('size_inch'),
            'area_tile_sqft' => $request->input('area_tile_sqft'),
            'pattern_type' => $request->input('pattern_type'),
            'edge_type' => $request->input('edge_type'),
            'pieces_per_box' => $request->input('pieces_per_box'),
            'coverage_per_box_sqft' => $request->input('coverage_per_box_sqft'),
            'weight_per_box_kg' => $request->input('weight_per_box_kg'),
            'price_per_box' => $request->input('price_per_box'),
            'wholesale_price' => $request->input('wholesale_price'),
            'price_per_sqft' => $request->input('price_per_sqft'),
            'application_area' => $request->input('application_area'),
            // SEO
            'seo_meta_title' => $request->input('seo_meta_title'),
            'seo_meta_description' => $request->input('seo_meta_description'),
            'catalog_page' => $request->input('catalog_page'),
            // Toggles
            'is_featured' => $request->boolean('is_featured'),
            'is_trending' => $request->boolean('is_trending'),
            'is_new' => $request->boolean('is_new', true),
        ]);

        ProductImage::create([
            'product_id' => $product->id,
            'image_path' => $imagePath,
            'is_primary' => true
        ]);

        return redirect()->route('admin.products')->with('success', 'Product created successfully.');
    }

    public function productEdit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::with('subCategories')->get();
        $rooms = Room::all();
        $brands = Brand::all();
        $attributes = ProductAttribute::getAllGrouped();
        $subCategories = SubCategory::orderBy('sort_order')->get();
        return view('admin.products.edit', compact('product', 'categories', 'rooms', 'brands', 'attributes', 'subCategories'));
    }

    public function productUpdate(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:products,sku,' . $product->id,
            'mrp' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'room_id' => 'required|exists:rooms,id',
            'brand_id' => 'required|exists:brands,id',
            'image' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/products'), $fileName);
            $imagePath = 'images/products/' . $fileName;

            // Delete old images and set new primary
            ProductImage::where('product_id', $product->id)->delete();
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $imagePath,
                'is_primary' => true
            ]);
        }

        $product->update([
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('name')),
            'sku' => $request->input('sku'),
            'description' => $request->input('description'),
            'short_description' => $request->input('short_description'),
            'mrp' => $request->input('mrp'),
            'price' => $request->input('price'),
            'discount' => max(0, $request->input('mrp') - $request->input('price')),
            'stock' => $request->input('stock'),
            'category_id' => $request->input('category_id'),
            'room_id' => $request->input('room_id'),
            'brand_id' => $request->input('brand_id'),
            // Specs
            'size' => $request->input('size'),
            'color' => $request->input('color'),
            'finish' => $request->input('finish'),
            'material' => $request->input('material'),
            'thickness' => $request->input('thickness'),
            'coverage_area' => $request->input('coverage_area'),
            'water_absorption' => $request->input('water_absorption'),
            'warranty' => $request->input('warranty'),
            'delivery_time' => $request->input('delivery_time'),
            'gst_percent' => $request->input('gst_percent', 18),
            // Spreadsheet fields
            'collection' => $request->input('collection'),
            'sub_category' => $request->input('sub_category'),
            'width_mm' => $request->input('width_mm'),
            'height_mm' => $request->input('height_mm'),
            'size_inch' => $request->input('size_inch'),
            'area_tile_sqft' => $request->input('area_tile_sqft'),
            'pattern_type' => $request->input('pattern_type'),
            'edge_type' => $request->input('edge_type'),
            'pieces_per_box' => $request->input('pieces_per_box'),
            'coverage_per_box_sqft' => $request->input('coverage_per_box_sqft'),
            'weight_per_box_kg' => $request->input('weight_per_box_kg'),
            'price_per_box' => $request->input('price_per_box'),
            'wholesale_price' => $request->input('wholesale_price'),
            'price_per_sqft' => $request->input('price_per_sqft'),
            'application_area' => $request->input('application_area'),
            // SEO
            'seo_meta_title' => $request->input('seo_meta_title'),
            'seo_meta_description' => $request->input('seo_meta_description'),
            'catalog_page' => $request->input('catalog_page'),
            // Toggles
            'is_featured' => $request->boolean('is_featured'),
            'is_trending' => $request->boolean('is_trending'),
            'is_new' => $request->boolean('is_new'),
        ]);

        return redirect()->route('admin.products')->with('success', 'Product updated successfully.');
    }

    public function productDelete($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('admin.products')->with('success', 'Product deleted.');
    }

    /* -------------------------------------------------------------
     * CRUD: CATEGORIES
     * ------------------------------------------------------------- */

    public function categories()
    {
        $categories = Category::with('subCategories')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function categoryStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'image' => 'nullable|image|max:2048'
        ]);

        $imagePath = 'images/categories/tiles.svg'; // fallback
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/categories'), $fileName);
            $imagePath = 'images/categories/' . $fileName;
        }

        Category::create([
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('name')),
            'image' => $imagePath
        ]);

        return redirect()->back()->with('success', 'Category created.');
    }

    public function categoryDelete($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->back()->with('success', 'Category deleted.');
    }

    /* -------------------------------------------------------------
     * CRUD: BANNERS
     * ------------------------------------------------------------- */

    public function banners()
    {
        $banners = Banner::all();
        return view('admin.banners.index', compact('banners'));
    }

    public function bannerStore(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string',
            'link' => 'nullable|string',
            'image' => 'required|image|max:2048'
        ]);

        $imagePath = 'images/banners/banner1.svg';
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/banners'), $fileName);
            $imagePath = 'images/banners/' . $fileName;
        }

        Banner::create([
            'title' => $request->input('title'),
            'subtitle' => $request->input('subtitle'),
            'link' => $request->input('link', '/products'),
            'image' => $imagePath,
            'type' => 'slider',
            'is_active' => true
        ]);

        return redirect()->back()->with('success', 'Banner created.');
    }

    public function bannerDelete($id)
    {
        $banner = Banner::findOrFail($id);
        $banner->delete();
        return redirect()->back()->with('success', 'Banner deleted.');
    }

    public function categoryEdit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function categoryUpdate(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'image' => 'nullable|image|max:2048'
        ]);

        $imagePath = $category->image;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/categories'), $fileName);
            $imagePath = 'images/categories/' . $fileName;
        }

        $category->update([
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('name')),
            'image' => $imagePath
        ]);

        return redirect()->route('admin.categories')->with('success', 'Category updated.');
    }

    /* --- Sub Categories --- */

    public function subCategoryStore(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048'
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/subcategories'), $fileName);
            $imagePath = 'images/subcategories/' . $fileName;
        }

        SubCategory::create([
            'category_id' => $request->input('category_id'),
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('name')),
            'image' => $imagePath,
            'sort_order' => SubCategory::where('category_id', $request->input('category_id'))->max('sort_order') + 1,
        ]);

        return redirect()->back()->with('success', 'Sub Category added.');
    }

    public function subCategoryEdit($id)
    {
        $subCategory = SubCategory::with('category')->findOrFail($id);
        $categories = Category::all();
        return view('admin.categories.edit_sub', compact('subCategory', 'categories'));
    }

    public function subCategoryUpdate(Request $request, $id)
    {
        $subCategory = SubCategory::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048'
        ]);

        $imagePath = $subCategory->image;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/subcategories'), $fileName);
            $imagePath = 'images/subcategories/' . $fileName;
        }

        $subCategory->update([
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('name')),
            'category_id' => $request->input('category_id'),
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.categories')->with('success', 'Sub Category updated.');
    }

    public function subCategoryDelete($id)
    {
        $sub = SubCategory::findOrFail($id);
        $sub->delete();
        return redirect()->back()->with('success', 'Sub Category deleted.');
    }

    public function bannerEdit($id)
    {
        $banner = Banner::findOrFail($id);
        return view('admin.banners.edit', compact('banner'));
    }

    public function bannerUpdate(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string',
            'link' => 'nullable|string',
            'image' => 'nullable|image|max:2048'
        ]);

        $imagePath = $banner->image;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/banners'), $fileName);
            $imagePath = 'images/banners/' . $fileName;
        }

        $banner->update([
            'title' => $request->input('title'),
            'subtitle' => $request->input('subtitle'),
            'link' => $request->input('link'),
            'image' => $imagePath
        ]);

        return redirect()->route('admin.banners')->with('success', 'Banner updated.');
    }

    /* -------------------------------------------------------------
     * CRUD: ROOM SPACE
     * ------------------------------------------------------------- */

    public function roomSpaces()
    {
        $rooms = Room::all();
        return view('admin.room_spaces.index', compact('rooms'));
    }

    public function roomSpaceStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:rooms,name',
            'image' => 'nullable|image|max:2048'
        ]);

        $imagePath = 'images/rooms/room.svg'; // fallback
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/rooms'), $fileName);
            $imagePath = 'images/rooms/' . $fileName;
        }

        Room::create([
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('name')),
            'image' => $imagePath
        ]);

        return redirect()->back()->with('success', 'Room Space created.');
    }

    public function roomSpaceEdit($id)
    {
        $room = Room::findOrFail($id);
        return view('admin.room_spaces.edit', compact('room'));
    }

    public function roomSpaceUpdate(Request $request, $id)
    {
        $room = Room::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255|unique:rooms,name,' . $room->id,
            'image' => 'nullable|image|max:2048'
        ]);

        $imagePath = $room->image;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/rooms'), $fileName);
            $imagePath = 'images/rooms/' . $fileName;
        }

        $room->update([
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('name')),
            'image' => $imagePath
        ]);

        return redirect()->route('admin.room-spaces')->with('success', 'Room Space updated.');
    }

    public function roomSpaceDelete($id)
    {
        $room = Room::findOrFail($id);
        $room->delete();
        return redirect()->back()->with('success', 'Room Space deleted.');
    }

    /* -------------------------------------------------------------
     * CRUD: PRODUCT ATTRIBUTES (Variant Options)
     * ------------------------------------------------------------- */

    public function productAttributes()
    {
        $types = ProductAttribute::TYPES;
        $attributes = ProductAttribute::orderBy('type')->orderBy('sort_order')->orderBy('value')->get()->groupBy('type');
        return view('admin.product_attributes.index', compact('types', 'attributes'));
    }

    public function productAttributeStore(Request $request)
    {
        $request->validate([
            'type' => 'required|string|in:' . implode(',', array_keys(ProductAttribute::TYPES)),
            'value' => 'required|string|max:255',
        ]);

        ProductAttribute::create([
            'type' => $request->input('type'),
            'value' => $request->input('value'),
            'sort_order' => ProductAttribute::where('type', $request->input('type'))->max('sort_order') + 1,
            'is_active' => true,
        ]);

        return redirect()->back()->with('success', 'Variant option added: ' . $request->input('value'));
    }

    public function productAttributeToggle($id)
    {
        $attr = ProductAttribute::findOrFail($id);
        $attr->update(['is_active' => !$attr->is_active]);
        return redirect()->back()->with('success', $attr->value . ' ' . ($attr->is_active ? 'activated' : 'deactivated') . '.');
    }

    public function productAttributeUpdate(Request $request, $id)
    {
        $attr = ProductAttribute::findOrFail($id);
        $request->validate([
            'value' => 'required|string|max:255',
        ]);
        $attr->update([
            'value' => $request->input('value'),
            'sort_order' => $request->input('sort_order', $attr->sort_order),
        ]);
        return redirect()->back()->with('success', 'Variant option updated.');
    }

    public function productAttributeDelete($id)
    {
        $attr = ProductAttribute::findOrFail($id);
        $name = $attr->value;
        $attr->delete();
        return redirect()->back()->with('success', 'Variant option "' . $name . '" deleted.');
    }

    /* -------------------------------------------------------------
     * CRUD: BRANDS
     * ------------------------------------------------------------- */

    public function brands()
    {
        $brands = Brand::withCount('products')->get();
        return view('admin.brands.index', compact('brands'));
    }

    public function brandStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:brands,name',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|max:2048'
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/brands'), $fileName);
            $logoPath = 'images/brands/' . $fileName;
        }

        Brand::create([
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('name')),
            'description' => $request->input('description'),
            'logo' => $logoPath,
        ]);

        return redirect()->back()->with('success', 'Brand created.');
    }

    public function brandEdit($id)
    {
        $brand = Brand::findOrFail($id);
        return view('admin.brands.edit', compact('brand'));
    }

    public function brandUpdate(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255|unique:brands,name,' . $brand->id,
            'description' => 'nullable|string',
            'logo' => 'nullable|image|max:2048'
        ]);

        $logoPath = $brand->logo;
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/brands'), $fileName);
            $logoPath = 'images/brands/' . $fileName;
        }

        $brand->update([
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('name')),
            'description' => $request->input('description'),
            'logo' => $logoPath,
        ]);

        return redirect()->route('admin.brands')->with('success', 'Brand updated.');
    }

    public function brandDelete($id)
    {
        Brand::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Brand deleted.');
    }

    /* -------------------------------------------------------------
     * CRUD: COUPONS
     * ------------------------------------------------------------- */

    public function coupons()
    {
        $coupons = Coupon::orderBy('created_at', 'desc')->get();
        return view('admin.coupons.index', compact('coupons'));
    }

    public function couponStore(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:coupons,code',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'expires_at' => 'nullable|date',
        ]);

        Coupon::create([
            'code' => strtoupper($request->input('code')),
            'type' => $request->input('type'),
            'value' => $request->input('value'),
            'min_order_amount' => $request->input('min_order_amount', 0),
            'expires_at' => $request->input('expires_at'),
            'is_active' => true,
        ]);

        return redirect()->back()->with('success', 'Coupon created.');
    }

    public function couponToggle($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->update(['is_active' => !$coupon->is_active]);
        return redirect()->back()->with('success', 'Coupon ' . ($coupon->is_active ? 'activated' : 'deactivated') . '.');
    }

    public function couponDelete($id)
    {
        Coupon::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Coupon deleted.');
    }
}

