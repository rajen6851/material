<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $banners = \App\Models\Banner::where('is_active', true)->get();
    $rooms = \App\Models\Room::all();
    $categories = \App\Models\Category::with('subCategories')->get();
    $brands = \App\Models\Brand::all();
    $featuredProducts = \App\Models\Product::where('is_featured', true)->take(8)->get();
    $newProducts = \App\Models\Product::where('is_new', true)->take(8)->get();
    
    return view('welcome', compact('banners', 'rooms', 'categories', 'brands', 'featuredProducts', 'newProducts'));
});

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

use App\Http\Controllers\CategoryController;
Route::get('/category/{category:slug}', [CategoryController::class, 'show'])->name('category.show');

// Cart Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/coupon', [CartController::class, 'applyCoupon'])->name('cart.coupon');
Route::post('/buy-now', [CartController::class, 'buyNow'])->name('buy.now');

// Checkout Routes (Requires Auth)
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout.index');
    Route::post('/checkout/place', [CartController::class, 'placeOrder'])->name('checkout.place');
    Route::get('/checkout/success/{id}', [CartController::class, 'success'])->name('checkout.success');
});

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;

// Dashboard & Services Routes (Requires Auth)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/quotation-requests/create', [DashboardController::class, 'createQuotation'])->name('quotation.create')->middleware('role:professional');
    Route::post('/quotation-requests', [DashboardController::class, 'storeQuotation'])->name('quotation.store')->middleware('role:professional');
    
    // Admin Routes
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/orders', [AdminController::class, 'orders'])->name('admin.orders');
    Route::post('/admin/orders/{id}/status', [AdminController::class, 'updateOrderStatus'])->name('admin.orders.status');
    Route::get('/admin/quotations', [AdminController::class, 'quotations'])->name('admin.quotations');
    Route::post('/admin/quotations/{id}/respond', [AdminController::class, 'respondQuotation'])->name('admin.quotations.respond');
    Route::get('/admin/visits', [AdminController::class, 'visits'])->name('admin.visits');
    Route::post('/admin/visits/{id}/status', [AdminController::class, 'updateVisitStatus'])->name('admin.visits.status');

    // Admin CRUD: Products
    Route::get('/admin/products', [AdminController::class, 'products'])->name('admin.products');
    Route::get('/admin/products/create', [AdminController::class, 'productCreate'])->name('admin.products.create');
    Route::post('/admin/products/store', [AdminController::class, 'productStore'])->name('admin.products.store');
    Route::get('/admin/products/{id}/edit', [AdminController::class, 'productEdit'])->name('admin.products.edit');
    Route::post('/admin/products/{id}/update', [AdminController::class, 'productUpdate'])->name('admin.products.update');
    Route::post('/admin/products/{id}/delete', [AdminController::class, 'productDelete'])->name('admin.products.delete');

    // Admin CRUD: Categories
    Route::get('/admin/categories', [AdminController::class, 'categories'])->name('admin.categories');
    Route::post('/admin/categories/store', [AdminController::class, 'categoryStore'])->name('admin.categories.store');
    Route::get('/admin/categories/{id}/edit', [AdminController::class, 'categoryEdit'])->name('admin.categories.edit');
    Route::post('/admin/categories/{id}/update', [AdminController::class, 'categoryUpdate'])->name('admin.categories.update');
    Route::post('/admin/categories/{id}/delete', [AdminController::class, 'categoryDelete'])->name('admin.categories.delete');

    // Admin CRUD: Sub Categories
    Route::post('/admin/sub-categories/store', [AdminController::class, 'subCategoryStore'])->name('admin.sub-categories.store');
    Route::get('/admin/sub-categories/{id}/edit', [AdminController::class, 'subCategoryEdit'])->name('admin.sub-categories.edit');
    Route::post('/admin/sub-categories/{id}/update', [AdminController::class, 'subCategoryUpdate'])->name('admin.sub-categories.update');
    Route::post('/admin/sub-categories/{id}/delete', [AdminController::class, 'subCategoryDelete'])->name('admin.sub-categories.delete');

    // Admin CRUD: Banners
    Route::get('/admin/banners', [AdminController::class, 'banners'])->name('admin.banners');
    Route::post('/admin/banners/store', [AdminController::class, 'bannerStore'])->name('admin.banners.store');
    Route::get('/admin/banners/{id}/edit', [AdminController::class, 'bannerEdit'])->name('admin.banners.edit');
    Route::post('/admin/banners/{id}/update', [AdminController::class, 'bannerUpdate'])->name('admin.banners.update');
    Route::post('/admin/banners/{id}/delete', [AdminController::class, 'bannerDelete'])->name('admin.banners.delete');

// Admin CRUD: Room Spaces
    Route::get('/admin/room-spaces', [AdminController::class, 'roomSpaces'])->name('admin.room-spaces');
    Route::post('/admin/room-spaces/store', [AdminController::class, 'roomSpaceStore'])->name('admin.room-spaces.store');
    Route::get('/admin/room-spaces/{id}/edit', [AdminController::class, 'roomSpaceEdit'])->name('admin.room-spaces.edit');
    Route::post('/admin/room-spaces/{id}/update', [AdminController::class, 'roomSpaceUpdate'])->name('admin.room-spaces.update');
    Route::post('/admin/room-spaces/{id}/delete', [AdminController::class, 'roomSpaceDelete'])->name('admin.room-spaces.delete');

    // Admin CRUD: Product Attributes (Variant Options)
    Route::get('/admin/product-attributes', [AdminController::class, 'productAttributes'])->name('admin.product-attributes');
    Route::post('/admin/product-attributes/store', [AdminController::class, 'productAttributeStore'])->name('admin.product-attributes.store');
    Route::post('/admin/product-attributes/{id}/toggle', [AdminController::class, 'productAttributeToggle'])->name('admin.product-attributes.toggle');
    Route::post('/admin/product-attributes/{id}/update', [AdminController::class, 'productAttributeUpdate'])->name('admin.product-attributes.update');
    Route::post('/admin/product-attributes/{id}/delete', [AdminController::class, 'productAttributeDelete'])->name('admin.product-attributes.delete');

    // Admin CRUD: Brands
    Route::get('/admin/brands', [AdminController::class, 'brands'])->name('admin.brands');
    Route::post('/admin/brands/store', [AdminController::class, 'brandStore'])->name('admin.brands.store');
    Route::get('/admin/brands/{id}/edit', [AdminController::class, 'brandEdit'])->name('admin.brands.edit');
    Route::post('/admin/brands/{id}/update', [AdminController::class, 'brandUpdate'])->name('admin.brands.update');
    Route::post('/admin/brands/{id}/delete', [AdminController::class, 'brandDelete'])->name('admin.brands.delete');

    // Admin CRUD: Coupons
    Route::get('/admin/coupons', [AdminController::class, 'coupons'])->name('admin.coupons');
    Route::post('/admin/coupons/store', [AdminController::class, 'couponStore'])->name('admin.coupons.store');
    Route::post('/admin/coupons/{id}/toggle', [AdminController::class, 'couponToggle'])->name('admin.coupons.toggle');
    Route::post('/admin/coupons/{id}/delete', [AdminController::class, 'couponDelete'])->name('admin.coupons.delete');
});


// Showroom Visit Booking (Public)
Route::get('/showroom-visit/book', [DashboardController::class, 'bookShowroomForm'])->name('showroom.book');
Route::post('/showroom-visit', [DashboardController::class, 'bookShowroom'])->name('showroom.store');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
