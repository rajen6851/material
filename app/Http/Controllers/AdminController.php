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

    public function productImportForm()
    {
        return view('admin.products.import');
    }

    public function productImportSample()
    {
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=products_bulk_import_sample.csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = [
            'S.No', 'Tile Image', 'Tile Name', 'Collection', 'Category', 'Sub Category',
            'Finish', 'Width (mm)', 'Height (mm)', 'Size', 'Thickness (mm)', 'Size (inch)',
            'Area/Tile (sqft)', 'Pattern Type', 'Edge Type', 'SKU / Product Code',
            'Pieces per box', 'Coverage per box (sqft)', 'Weight per box (kg)',
            'Price per box', 'Price per sqft', 'Application Area', 'Stock status',
            'Short Description', 'SEO Meta Title', 'SEO Meta Description', 'URL Slug', 'Catalog Page'
        ];

        $sampleRow1 = [
            '1', 'images/products/emesa-white.svg', 'Emesa White', 'Glossy', 'TILES', 'GVT',
            'Glossy', '600', '1200', '600x1200mm', '9 MM', '24x48',
            '8', 'Standard', 'Square', 'EMESA-1200W',
            '2', '16', '30', '880', '55', 'Bathroom / Floor', 'In Stock',
            'Craft a statement with Emesa White, blending crisp white tones with a Glossy finish in a Standard pattern.',
            'Complete Your Space With Emesa White Glossy Tile Online',
            'Now available: Emesa White - crisp white tones, Glossy finish, Standard pattern, sized 600x1200mm.',
            'emesa-white', '1'
        ];

        $sampleRow2 = [
            '2', 'images/products/satvario-bronz.svg', 'Satvario Bronz', 'Glossy', 'TILES', 'GVT',
            'Glossy', '600', '1200', '600x1200mm', '9 MM', '24x48',
            '8', 'Standard', 'Square', 'SATVARIO-1200B',
            '2', '16', '30', '880', '55', 'Living Room / Floor', 'In Stock',
            'Frame your space with Satvario Bronz - a rich brown tile with a Glossy finish.',
            'Style With Satvario Bronz Glossy Tile Online',
            'Rich Satvario Bronz - a rich brown Glossy Finish Standard tile in 600x1200mm.',
            'satvario-bronz', '2'
        ];

        $callback = function() use ($columns, $sampleRow1, $sampleRow2) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            fputcsv($file, $sampleRow1);
            fputcsv($file, $sampleRow2);
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function productImportProcess(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|max:20480',
        ]);

        $file = $request->file('csv_file');
        $rawPath = $file->getRealPath();
        $fileContent = file_get_contents($rawPath);

        if (!$fileContent) {
            return redirect()->back()->with('error', 'The uploaded file is empty.');
        }

        // 1. Check if file is a binary XLSX / ZIP archive (starts with PK\x03\x04)
        if (substr($fileContent, 0, 4) === "PK\x03\x04") {
            return redirect()->back()->with('error', 'The uploaded file is an Excel (.xlsx) binary file. Please open it in Excel, click "Save As", and select "CSV (Comma delimited) (*.csv)" before uploading.');
        }

        // 2. Detect & convert multi-byte encodings (UTF-16LE, UTF-16BE, Windows-1252, ISO-8859-1) to UTF-8
        $detected = mb_detect_encoding($fileContent, ['UTF-8', 'UTF-16LE', 'UTF-16BE', 'Windows-1252', 'ISO-8859-1', 'ASCII'], true);
        if ($detected && $detected !== 'UTF-8') {
            $fileContent = mb_convert_encoding($fileContent, 'UTF-8', $detected);
        }

        // Remove UTF-8 BOM if present
        $fileContent = preg_replace('/^\xEF\xBB\xBF/', '', $fileContent);

        // Sanitize string to clean UTF-8 using iconv
        $sanitizedContent = @iconv('UTF-8', 'UTF-8//IGNORE', $fileContent);
        if ($sanitizedContent) {
            $fileContent = $sanitizedContent;
        }

        // Create temp memory stream for fgetcsv
        $handle = fopen('php://memory', 'r+');
        fwrite($handle, $fileContent);
        rewind($handle);

        // Auto-detect delimiter (, or ; or \t)
        $firstLine = fgets($handle);
        rewind($handle);
        $delimiter = ',';
        if ($firstLine) {
            $commaCount = substr_count($firstLine, ',');
            $tabCount = substr_count($firstLine, "\t");
            $semiCount = substr_count($firstLine, ';');
            if ($tabCount > $commaCount && $tabCount > $semiCount) {
                $delimiter = "\t";
            } elseif ($semiCount > $commaCount && $semiCount > $tabCount) {
                $delimiter = ";";
            }
        }

        // Helper to sanitize individual string cells for DB safety
        $cleanStr = function($val) {
            if ($val === null || $val === '') return null;
            $val = trim($val);
            $val = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $val);
            $safe = @iconv('UTF-8', 'UTF-8//IGNORE', $val);
            return $safe !== false ? $safe : $val;
        };

        // Find actual header row by scanning up to 20 rows for header keywords
        $header = null;
        $headerLineNumber = 0;
        $lineNumber = 0;

        while (($candidateRow = fgetcsv($handle, 0, $delimiter)) !== false) {
            $lineNumber++;

            if (empty(array_filter($candidateRow))) {
                continue;
            }

            $rowStr = strtolower(implode(' ', $candidateRow));

            // Check if this row looks like a valid header row
            if (
                str_contains($rowStr, 'tile name') ||
                str_contains($rowStr, 'tilename') ||
                str_contains($rowStr, 'product name') ||
                str_contains($rowStr, 'sku') ||
                str_contains($rowStr, 's.no') ||
                str_contains($rowStr, 'sno') ||
                (str_contains($rowStr, 'name') && str_contains($rowStr, 'category'))
            ) {
                $header = $candidateRow;
                $headerLineNumber = $lineNumber;
                break;
            }
        }

        // If no explicit header detected, assume row 2 or row 1 as fallback header
        if (!$header) {
            rewind($handle);
            $headerLineNumber = 1;
            $header = fgetcsv($handle, 0, $delimiter);
        }

        // Clean headers for easy lookup
        $normalizedHeaders = $header ? array_map(function($h) {
            return strtolower(trim(preg_replace('/[^a-zA-Z0-9]/', '', $h)));
        }, $header) : [];

        // Helper to find cell value by candidate header names or fallback index
        $getCol = function($row, array $candidates, $fallbackIndex = null) use ($normalizedHeaders, $cleanStr) {
            foreach ($candidates as $cand) {
                $cleanCand = strtolower(trim(preg_replace('/[^a-zA-Z0-9]/', '', $cand)));
                $idx = array_search($cleanCand, $normalizedHeaders);
                if ($idx !== false && isset($row[$idx])) {
                    $val = $cleanStr($row[$idx]);
                    if ($val !== null && $val !== '') return $val;
                }
            }
            if ($fallbackIndex !== null && isset($row[$fallbackIndex])) {
                $val = $cleanStr($row[$fallbackIndex]);
                if ($val !== null && $val !== '') return $val;
            }
            return null;
        };

        // Cache category, room, brand lookups for speed
        $categoriesMap = Category::all()->pluck('id', 'name')->toArray();
        $categoriesSlugMap = Category::all()->pluck('id', 'slug')->toArray();
        $roomsMap = Room::all()->pluck('id', 'name')->toArray();
        $roomsSlugMap = Room::all()->pluck('id', 'slug')->toArray();
        $brandsMap = Brand::all()->pluck('id', 'name')->toArray();

        $defaultRoomId = !empty($roomsMap) ? reset($roomsMap) : Room::firstOrCreate(['name' => 'General', 'slug' => 'general'])->id;
        $defaultCategoryId = !empty($categoriesMap) ? reset($categoriesMap) : Category::firstOrCreate(['name' => 'Tiles', 'slug' => 'tiles'])->id;
        $defaultBrandId = !empty($brandsMap) ? reset($brandsMap) : Brand::firstOrCreate(['name' => 'Generic', 'slug' => 'generic'])->id;

        $createdCount = 0;
        $updatedCount = 0;
        $failedCount = 0;
        $errors = [];
        $lineNumber = $headerLineNumber;

        \Illuminate\Support\Facades\DB::beginTransaction();
        try {
            while (($row = fgetcsv($handle, 0, $delimiter)) !== false) {
                $lineNumber++;

                // Skip completely empty rows
                if (empty(array_filter($row))) {
                    continue;
                }

                // Column C (index 2): Tile Name
                $tileName = $getCol($row, ['Tile Name', 'TileName', 'Name', 'Product Name', 'Title', 'Product', 'Item Name', 'Tile'], 2);
                
                // Skip header row if re-encountered
                if (strtolower($tileName) === 'tile name' || strtolower($tileName) === 'name') {
                    continue;
                }

                if (!$tileName) {
                    $errors[] = "Row {$lineNumber}: Skipped - Missing product name.";
                    $failedCount++;
                    continue;
                }

                // Column E (index 4): Category
                $categoryName = $getCol($row, ['Category', 'Cat'], 4);
                $categoryId = $defaultCategoryId;
                if ($categoryName) {
                    $catClean = trim($categoryName);
                    $catSlug = Str::slug($catClean);
                    if (isset($categoriesMap[$catClean])) {
                        $categoryId = $categoriesMap[$catClean];
                    } elseif (isset($categoriesSlugMap[$catSlug])) {
                        $categoryId = $categoriesSlugMap[$catSlug];
                    } else {
                        $newCat = Category::create([
                            'name' => $catClean,
                            'slug' => $catSlug,
                            'image' => 'images/categories/tiles.svg'
                        ]);
                        $categoriesMap[$catClean] = $newCat->id;
                        $categoriesSlugMap[$catSlug] = $newCat->id;
                        $categoryId = $newCat->id;
                    }
                }

                // Column V (index 21): Application Area
                $appArea = $getCol($row, ['Application Area', 'ApplicationArea', 'Room', 'Application'], 21);
                $roomId = $defaultRoomId;
                if ($appArea) {
                    foreach ($roomsMap as $rName => $rId) {
                        if (stripos($appArea, $rName) !== false) {
                            $roomId = $rId;
                            break;
                        }
                    }
                }

                $brandName = $getCol($row, ['Brand']);
                $brandId = $defaultBrandId;
                if ($brandName && isset($brandsMap[trim($brandName)])) {
                    $brandId = $brandsMap[trim($brandName)];
                }

                // Column P (index 15): SKU
                $sku = $getCol($row, ['SKU / Product Code', 'SKU/Product Code', 'SKU', 'Product Code', 'Code'], 15);
                // Column AB / AA (index 26): URL Slug
                $slug = $getCol($row, ['URL Slug', 'URLSlug', 'Slug'], 26);
                if (!$slug || $slug === $tileName) {
                    $slug = Str::slug($tileName);
                }

                if (!$sku || is_numeric($sku) && (int)$sku < 100) {
                    $sku = strtoupper(Str::slug($tileName)) . '-' . rand(1000, 9999);
                }

                // Numeric parsing helpers
                $parseNum = function($val, $default = 0) {
                    if ($val === null) return $default;
                    $clean = preg_replace('/[^0-9\.]/', '', $val);
                    return is_numeric($clean) ? (float)$clean : $default;
                };

                // Column T (index 19): Price per Box & Column U (index 20): Price per Sq Ft
                $pricePerBox = $parseNum($getCol($row, ['Price per Box', 'Price per box', 'Price/Box', 'Price', 'MRP'], 19), 0);
                $pricePerSqft = $parseNum($getCol($row, ['Price per Sq.Ft', 'Price per Sq Ft', 'Price per sq.ft', 'Price per sqft'], 20), 0);
                $mrp = $pricePerBox > 0 ? $pricePerBox : ($pricePerSqft > 0 ? $pricePerSqft * 16 : 500);
                $price = $pricePerSqft > 0 ? $pricePerSqft : ($pricePerBox > 0 ? round($pricePerBox / 16, 2) : 50);

                // Column W / X (index 22 / 23): Stock Status
                $stockVal = $getCol($row, ['Stock Status', 'Priock Status', 'Stock status', 'Stock', 'Quantity', 'Status'], 23);
                if (!$stockVal) {
                    $stockVal = $getCol($row, [], 22);
                }
                $stock = 100;
                if ($stockVal) {
                    if (is_numeric($stockVal)) {
                        $stock = (int)$stockVal;
                    } elseif (stripos($stockVal, 'out') !== false) {
                        $stock = 0;
                    }
                }

                // Specs: Column H (7), I (8), J (9), K (10), L (11), M (12), N (13), O (14), Q (16), R (17), S (18)
                $widthMm = $parseNum($getCol($row, ['Width (mm)', 'Width(mm)', 'Width'], 7), 600);
                $heightMm = $parseNum($getCol($row, ['Height (mm)', 'Height(mm)', 'Height'], 8), 1200);
                $thickness = $getCol($row, ['Thickness (mm)', 'Thickness(mm)', 'Thickness'], 10) ?? '9 MM';
                $size = $getCol($row, ['Size (mm)', 'Size', 'Size(mm)'], 9) ?? ($widthMm . 'x' . $heightMm . 'mm');
                $sizeInch = $getCol($row, ['Size (Inch)', 'Size (inch)', 'Size(inch)'], 11) ?? '24x48';
                $collection = $getCol($row, ['Collection'], 3) ?? 'Glossy';
                $subCategory = $getCol($row, ['Sub Category', 'SubCategory', 'Sub-Category'], 5) ?? 'Floor Tiles';
                $finish = $getCol($row, ['Finish'], 6) ?? 'Glossy';
                $patternType = $getCol($row, ['Pattern Types', 'Pattern Type', 'PatternType', 'Pattern'], 13) ?? 'Standard';
                $edgeType = $getCol($row, ['Edge Type', 'EdgeType', 'Edge'], 14) ?? 'Square';
                $piecesPerBox = (int)$parseNum($getCol($row, ['Pieces per Box', 'Pieces per box', 'Pieces/Box'], 16), 2);
                $coveragePerBox = $parseNum($getCol($row, ['Coverage per Box (sq.ft)', 'Coverage per box (sqft)', 'Coverage'], 17), 16);
                $weightPerBox = $parseNum($getCol($row, ['Weight per Box (kg/ft)', 'Weight per Box (kg)', 'Weight'], 18), 30);
                $areaTileSqft = $parseNum($getCol($row, ['Area/Tile (sq.ft)', 'Area/Tile (sqft)', 'Area/Tile'], 12), 8);

                // Descriptions & Meta: Column Y (24), Z (25), AC (27)
                $shortDesc = $getCol($row, ['Short Description', 'ShortDescription', 'Description'], 24);
                $metaDesc = $getCol($row, ['SEO Meta Description', 'SEO Meta Title', 'Meta Description'], 25);
                $metaTitle = "Buy {$tileName} Tile Online";
                $catalogPage = $getCol($row, ['Catalog Page', 'CatalogPage', 'Page'], 27);
                $tileImage = $getCol($row, ['Tile Image', 'TileImage', 'Image', 'Image Path'], 1);

                $productData = [
                    'name' => $tileName,
                    'short_description' => $shortDesc,
                    'description' => $shortDesc ?? "High quality {$tileName} {$collection} tile.",
                    'mrp' => $mrp,
                    'price' => $price,
                    'discount' => 0.00,
                    'gst_percent' => 18.00,
                    'stock' => $stock,
                    'rating' => 4.90,
                    'category_id' => $categoryId,
                    'room_id' => $roomId,
                    'brand_id' => $brandId,
                    'collection' => $collection,
                    'sub_category' => $subCategory,
                    'finish' => $finish,
                    'material' => $subCategory ?: 'GVT',
                    'color' => 'White',
                    'size' => $size,
                    'width_mm' => $widthMm,
                    'height_mm' => $heightMm,
                    'size_inch' => $sizeInch,
                    'thickness' => $thickness,
                    'area_tile_sqft' => $areaTileSqft,
                    'pattern_type' => $patternType,
                    'edge_type' => $edgeType,
                    'pieces_per_box' => $piecesPerBox,
                    'coverage_per_box_sqft' => $coveragePerBox,
                    'weight_per_box_kg' => $weightPerBox,
                    'price_per_box' => $pricePerBox > 0 ? $pricePerBox : $mrp,
                    'price_per_sqft' => $pricePerSqft > 0 ? $pricePerSqft : $price,
                    'wholesale_price' => $pricePerBox > 0 ? round($pricePerBox * 0.9, 2) : round($price * 14, 2),
                    'coverage_area' => $coveragePerBox . ' sq. ft / box',
                    'water_absorption' => '< 0.05%',
                    'warranty' => '5 Years',
                    'delivery_time' => '3-5 Days',
                    'application_area' => $appArea,
                    'seo_meta_title' => $metaTitle,
                    'seo_meta_description' => $metaDesc,
                    'catalog_page' => $catalogPage,
                    'is_featured' => true,
                    'is_trending' => true,
                    'is_new' => true,
                ];

                // Check existing product by SKU or Slug
                $existingProduct = Product::where('sku', $sku)->orWhere('slug', $slug)->first();

                if ($existingProduct) {
                    $existingProduct->update($productData);
                    $product = $existingProduct;
                    $updatedCount++;
                } else {
                    $productData['sku'] = $sku;
                    $productData['slug'] = $slug;
                    $product = Product::create($productData);
                    $createdCount++;
                }

                // Add image if provided
                if ($tileImage) {
                    ProductImage::updateOrCreate(
                        ['product_id' => $product->id, 'is_primary' => true],
                        ['image_path' => $tileImage]
                    );
                }
            }

            \Illuminate\Support\Facades\DB::commit();
            fclose($handle);

            $msg = "Bulk Import Complete! Created: {$createdCount}, Updated: {$updatedCount}, Skipped/Failed: {$failedCount}.";
            return redirect()->route('admin.products.import.form')->with([
                'success' => $msg,
                'import_errors' => $errors,
                'created_count' => $createdCount,
                'updated_count' => $updatedCount,
                'failed_count' => $failedCount
            ]);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            fclose($handle);
            return redirect()->back()->with('error', 'Import failed due to error: ' . $e->getMessage());
        }
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

