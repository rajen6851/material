<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Admin\SpotlightController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;
use App\Models\SectionHeading;
use App\Models\Spotlight;
use App\Http\Controllers\Admin\PackageController as AdminPackageController;
use App\Http\Controllers\Public\PackageController as PublicPackageController;



// Public API for Service Area Verification
Route::get('/api/check-pincode', function (\Illuminate\Http\Request $request) {
    $pincode = $request->input('pincode');
    $allowedPincodes = config('delivery.pincodes', []);
    
    if (in_array($pincode, $allowedPincodes, true)) {
        return response()->json(['status' => 'success', 'message' => 'Delivery is available to ' . $pincode . ' (Bangalore).']);
    }
    
    return response()->json(['status' => 'error', 'message' => 'Sorry, we currently do not deliver to ' . $pincode . '. Service limited to Bangalore.']);
});

use App\Http\Controllers\AiIntegrationController;
use App\Http\Controllers\AiQuotationAdminController;

// AI Sales Assistant API & Client Proxy Routes
Route::post('/api/ai/chat', [AiIntegrationController::class, 'chat'])->middleware('throttle:60,1');
Route::get('/api/ai/products-internal', [AiIntegrationController::class, 'internalProducts']);
Route::post('/api/ai/quotes/draft', [AiIntegrationController::class, 'createDraftQuote']);


use App\Http\Controllers\Admin\SectionHeadingController;
Route::resource(
    'section-headings',
    SectionHeadingController::class
)->names('admin.section-headings');



Route::get('/', function () {
  
    $banners = \App\Models\Banner::where('is_active', true)->get();
    $rooms = \App\Models\Room::all();
    $categories = \App\Models\Category::with('subCategories')->get();
    $brands = \App\Models\Brand::all();
    $featuredProducts = \App\Models\Product::with(['brand', 'category', 'images'])->where('is_featured', true)->where('stock', '>', 0)->take(12)->get();
    if ($featuredProducts->isEmpty()) {
        $featuredProducts = \App\Models\Product::with(['brand', 'category', 'images'])->take(12)->get();
    }
    $is_new = \App\Models\Product::with(['brand', 'category', 'images'])->where('is_new', true)->where('stock', '>', 0)->take(12)->get();
    
    $is_trending = \App\Models\Product::with(['brand', 'category', 'images'])->where('is_trending', true)->where('stock', '>', 0)->take(12)->get();
    
    
    
    // Dynamically build bathroom categories & subcategories from DB
    $bathroomRoom = \App\Models\Room::where('slug', 'bathroom')->first();
    $bathroomProducts = $bathroomRoom ? \App\Models\Product::with(['category', 'images'])->whereHas('rooms', function($q) use ($bathroomRoom) { $q->where('rooms.id', $bathroomRoom->id); })->get() : collect();
    
    $spotlights = Spotlight::where('is_active', true)
    ->orderBy('sort_order', 'asc')
    ->get();

    $bathroomCategoriesData = [];
    foreach ($categories as $cat) {
        $catProducts = $bathroomProducts->where('category_id', $cat->id);
        
        $subItems = [];
        $addedSlugs = [];

        // 1. Include all official subcategories from sub_categories table
        if ($cat->subCategories->isNotEmpty()) {
            foreach ($cat->subCategories as $sc) {
                $matchingProds = $catProducts->filter(function($p) use ($sc) {
                    return \Illuminate\Support\Str::slug($p->sub_category) === $sc->slug 
                        || stripos($p->sub_category, $sc->name) !== false
                        || stripos($sc->name, (string)$p->sub_category) !== false;
                });
                if ($matchingProds->count() > 0) {
                    $firstProd = $matchingProds->first();
                    $subItems[] = [
                        'name' => $sc->name,
                        'slug' => $sc->slug,
                        'category_slug' => $cat->slug,
                        'image' => $firstProd ? asset($firstProd->featured_image) : ($sc->image ? asset($sc->image) : asset($cat->image)),
                        'count' => $matchingProds->count(),
                    ];
                    $addedSlugs[] = $sc->slug;
                }
            }
        }

        // 2. Also include any product sub_category not already captured
        $dbSubs = $catProducts->groupBy('sub_category');
        foreach ($dbSubs as $subName => $prods) {
            if ($subName) {
                $subSlug = \Illuminate\Support\Str::slug($subName);
                if (!in_array($subSlug, $addedSlugs)) {
                    $first = $prods->first();
                    $subItems[] = [
                        'name' => $subName,
                        'slug' => $subSlug,
                        'category_slug' => $cat->slug,
                        'image' => $first ? asset($first->featured_image) : asset($cat->image),
                        'count' => $prods->count(),
                    ];
                    $addedSlugs[] = $subSlug;
                }
            }
        }

        if ($catProducts->count() > 0 && !empty($subItems)) {
            $bathroomCategoriesData[$cat->slug] = [
                'title' => $cat->name,
                'slug' => $cat->slug,
                'description' => 'Explore luxury ' . strtolower($cat->name) . ' solutions for bathroom.',
                'items' => $subItems,
            ];
        }
    }
    
    $featuredHeading = SectionHeading::where(
    'section_key',
    'featured_products'
)->first();

$tendingHeading = SectionHeading::where(
    'section_key',
    'trending_products'
)->first();

    $latestInspirations = \App\Models\Inspiration::latest()->take(6)->get();

    return view('welcome', compact('tendingHeading','featuredHeading','spotlights','banners', 'rooms', 'categories', 'brands', 'featuredProducts', 'is_new','is_trending', 'bathroomCategoriesData', 'latestInspirations'));
});

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

// Public Packages (Configurations & Bathroom Combos)
Route::get('/packages', [PublicPackageController::class, 'index'])->name('packages.index');
Route::get('/packages/{slug}', [PublicPackageController::class, 'show'])->name('packages.show');

use App\Http\Controllers\CategoryController;
Route::get('/category/{category:slug}', [CategoryController::class, 'show'])->name('category.show');

use App\Http\Controllers\RoomController;
Route::get('/spaces/{room:slug}', [RoomController::class, 'show'])->name('rooms.show');
Route::get('/rooms/{room:slug}', [RoomController::class, 'show']);

use App\Http\Controllers\InspirationController;
Route::get('/inspiration', [InspirationController::class, 'index'])->name('inspiration.index');
Route::get('/gallery', [InspirationController::class, 'index'])->name('gallery.index');

use App\Http\Controllers\PageController;
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [PageController::class, 'contactSubmit'])->name('contact.submit');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/about-us', [PageController::class, 'about']);
Route::get('/terms-conditions', [PageController::class, 'terms'])->name('terms');
Route::get('/terms', [PageController::class, 'terms']);
Route::get('/privacy-policy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/shipping-policy', [PageController::class, 'shipping'])->name('shipping');
Route::get('/return-policy', [PageController::class, 'returns'])->name('returns');
Route::get('/faqs', [PageController::class, 'faqs'])->name('faqs');
Route::get('/blog', [PageController::class, 'blog'])->name('blog');
Route::get('/blog/{slug}', [PageController::class, 'blogShow'])->name('blog.show');

// Cart Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/coupon', [CartController::class, 'applyCoupon'])->name('cart.coupon');
Route::post('/buy-now', [CartController::class, 'buyNow'])->name('buy.now');

use App\Http\Controllers\CompareController;
// Compare Routes
Route::get('/compare', [CompareController::class, 'index'])->name('compare.index');
Route::post('/compare/add', [CompareController::class, 'add'])->name('compare.add');
Route::post('/compare/remove', [CompareController::class, 'remove'])->name('compare.remove');
Route::post('/compare/clear', [CompareController::class, 'clear'])->name('compare.clear');

use App\Http\Controllers\WishlistController;
// Wishlist Routes
Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
Route::get('/wishlist/add/{id}', [WishlistController::class, 'add'])->name('wishlist.add');
Route::post('/wishlist/remove/{id}', [WishlistController::class, 'remove'])->name('wishlist.remove');
Route::post('/wishlist/clear', [WishlistController::class, 'clear'])->name('wishlist.clear');

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
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/admin/reports', [AdminController::class, 'reports'])->name('admin.reports');
    Route::get('/admin/orders', [AdminController::class, 'orders'])->name('admin.orders');
    Route::get('/admin/orders/{id}', [AdminController::class, 'orderShow'])->name('admin.orders.show');
    Route::get('/admin/orders/{id}/invoice', [AdminController::class, 'orderInvoice'])->name('admin.orders.invoice');
    Route::post('/admin/orders/{id}/status', [AdminController::class, 'updateOrderStatus'])->name('admin.orders.status');
    Route::get('/admin/quotations', [AdminController::class, 'quotations'])->name('admin.quotations');
    Route::post('/admin/quotations/{id}/respond', [AdminController::class, 'respondQuotation'])->name('admin.quotations.respond');

    // AI Quotations Desk
    Route::get('/admin/ai-quotes', [AiQuotationAdminController::class, 'index'])->name('admin.ai-quotes.index');
    Route::get('/admin/ai-quotes/{id}', [AiQuotationAdminController::class, 'show'])->name('admin.ai-quotes.show');
    Route::post('/admin/ai-quotes/{id}/approve', [AiQuotationAdminController::class, 'approve'])->name('admin.ai-quotes.approve');
    Route::post('/admin/ai-quotes/{id}/reject', [AiQuotationAdminController::class, 'reject'])->name('admin.ai-quotes.reject');
    Route::post('/admin/ai-quotes/{id}/send', [AiQuotationAdminController::class, 'send'])->name('admin.ai-quotes.send');

    Route::get('/admin/visits', [AdminController::class, 'visits'])->name('admin.visits');
    Route::post('/admin/visits/{id}/status', [AdminController::class, 'updateVisitStatus'])->name('admin.visits.status');
    Route::get('/admin/inquiries', [AdminController::class, 'inquiries'])->name('admin.inquiries');
    Route::post('/admin/inquiries/{id}/status', [AdminController::class, 'inquiryStatus'])->name('admin.inquiries.status');
    
  
Route::get(
    '/admin/products/search-related',
    [AdminController::class, 'searchRelatedProducts']
)->name('admin.products.search-related');
    
    // Admin Website Settings
    Route::get('/admin/website-settings', [AdminController::class, 'websiteSettings'])->name('admin.website-settings');
    Route::post('/admin/website-settings', [AdminController::class, 'updateWebsiteSettings'])->name('admin.website-settings.update');

    // Admin CRUD: Products
    Route::get('/admin/products', [AdminController::class, 'products'])->name('admin.products');
    Route::get('/admin/products/create', [AdminController::class, 'productCreate'])->name('admin.products.create');
    Route::post('/admin/products/store', [AdminController::class, 'productStore'])->name('admin.products.store');
    Route::get('/admin/products/import', [AdminController::class, 'productImportForm'])->name('admin.products.import.form');
    Route::post('/admin/products/import', [AdminController::class, 'productImportProcess'])->name('admin.products.import.process');
    Route::get('/admin/products/import-sample', [AdminController::class, 'productImportSample'])->name('admin.products.import.sample');
    Route::get('/admin/products/{id}/edit', [AdminController::class, 'productEdit'])->name('admin.products.edit');
    Route::post('/admin/products/{id}/update', [AdminController::class, 'productUpdate'])->name('admin.products.update');
    Route::post('/admin/products/{id}/delete', [AdminController::class, 'productDelete'])->name('admin.products.delete');
    
    Route::patch(
    '/products/{id}/featured',
    [AdminController::class, 'toggleFeatured']
)->name('admin.products.featured');

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
    
      Route::get('/spotlights', [SpotlightController::class, 'index'])
        ->name('admin.spotlights.index');

    Route::get('/spotlights/create', [SpotlightController::class, 'create'])
        ->name('admin.spotlights.create');

    Route::post('/spotlights', [SpotlightController::class, 'store'])
        ->name('admin.spotlights.store');

    Route::get('/spotlights/{spotlight}/edit', [SpotlightController::class, 'edit'])
        ->name('admin.spotlights.edit');

    Route::put('/spotlights/{spotlight}', [SpotlightController::class, 'update'])
        ->name('admin.spotlights.update');

    Route::delete('/spotlights/{spotlight}', [SpotlightController::class, 'destroy'])
        ->name('admin.spotlights.delete');

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
    // Admin CRUD: Blogs
    
    Route::resource('/admin/blogs', \App\Http\Controllers\Admin\BlogController::class, ['as' => 'admin']);
    
    // Admin CRUD: Inspirations (Gallery)
    Route::resource('/admin/inspirations', \App\Http\Controllers\Admin\InspirationController::class, ['as' => 'admin']);

    // Admin CRUD: Bathroom Packages & Configurations
    Route::get('/admin/packages', [AdminPackageController::class, 'index'])->name('admin.packages.index');
    Route::get('/admin/packages/create', [AdminPackageController::class, 'create'])->name('admin.packages.create');
    Route::post('/admin/packages', [AdminPackageController::class, 'store'])->name('admin.packages.store');
    Route::get('/admin/packages/{id}/edit', [AdminPackageController::class, 'edit'])->name('admin.packages.edit');
    Route::put('/admin/packages/{id}', [AdminPackageController::class, 'update'])->name('admin.packages.update');
    Route::post('/admin/packages/{id}/toggle', [AdminPackageController::class, 'toggle'])->name('admin.packages.toggle');
    Route::delete('/admin/packages/{id}', [AdminPackageController::class, 'destroy'])->name('admin.packages.destroy');

    // Admin CRUD: Package Items (Area-wise items)
    Route::post('/admin/packages/{packageId}/items', [AdminPackageController::class, 'storeItem'])->name('admin.packages.items.store');
    Route::post('/admin/packages/{packageId}/bulk-add-products', [AdminPackageController::class, 'bulkAddProducts'])->name('admin.packages.items.bulk-add');
    Route::put('/admin/packages/items/{itemId}', [AdminPackageController::class, 'updateItem'])->name('admin.packages.items.update');
    Route::delete('/admin/packages/items/{itemId}', [AdminPackageController::class, 'destroyItem'])->name('admin.packages.items.destroy');
    Route::get('/admin/packages/search-products', [AdminPackageController::class, 'searchProducts'])->name('admin.packages.search-products');
});


Route::post(
    '/admin/products/bulk-delete',
    [AdminController::class, 'bulkDelete']
)->name('admin.products.bulk-delete');


// Showroom Visit Booking (Public)
Route::get('/showroom-visit/book', [DashboardController::class, 'bookShowroomForm'])->name('showroom.book');
Route::post('/showroom-visit', [DashboardController::class, 'bookShowroom'])->name('showroom.store');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
