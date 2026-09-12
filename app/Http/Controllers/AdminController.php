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
     * Manage Orders with eager loaded items, products, and customer details.
     */
    public function orders(Request $request)
    {
        $status = $request->query('status');
        $search = $request->query('search');

        $query = Order::with(['items.product', 'user'])->orderBy('created_at', 'desc');

        if ($status && $status !== 'all') {
            $query->where('order_status', $status);
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $orders = $query->paginate(20)->withQueryString();

        $counts = [
            'all' => Order::count(),
            'pending' => Order::where('order_status', 'pending')->count(),
            'packed' => Order::where('order_status', 'packed')->count(),
            'shipped' => Order::where('order_status', 'shipped')->count(),
            'delivered' => Order::where('order_status', 'delivered')->count(),
            'cancelled' => Order::where('order_status', 'cancelled')->count(),
            'total_revenue' => Order::where('payment_status', 'paid')->sum('total'),
        ];

        return view('admin.orders', compact('orders', 'counts', 'status', 'search'));
    }

    /**
     * View Detailed Order Information.
     */
    public function orderShow($id)
    {
        $order = Order::with(['items.product', 'user'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Printable Official GST Tax Invoice.
     */
    public function orderInvoice($id)
    {
        $order = Order::with(['items.product', 'user'])->findOrFail($id);
        return view('admin.orders.invoice', compact('order'));
    }

    /**
     * Update Order Status and Payment Status.
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

        return redirect()->back()->with('success', 'Order #' . $order->order_number . ' status updated successfully.');
    }

    /**
     * Manage Contact Inquiries.
     */
    public function inquiries(Request $request)
    {
        $status = $request->query('status', 'all');
        $query = \App\Models\ContactInquiry::orderBy('created_at', 'desc');

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $inquiries = $query->paginate(20)->withQueryString();
        $unreadCount = \App\Models\ContactInquiry::where('status', 'unread')->count();

        return view('admin.inquiries', compact('inquiries', 'status', 'unreadCount'));
    }

    /**
     * Update Inquiry Status.
     */
    public function inquiryStatus(Request $request, $id)
    {
        $inquiry = \App\Models\ContactInquiry::findOrFail($id);
        $inquiry->update([
            'status' => $request->input('status', 'replied')
        ]);

        return redirect()->back()->with('success', 'Inquiry marked as ' . $request->input('status') . '.');
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
            'csv_file' => 'required|file|max:20480|mimes:csv,txt,xlsx,xls,ods',
        ]);

        $file = $request->file('csv_file');
        $rawPath = $file->getRealPath();
        $fileContent = file_get_contents($rawPath);

        if (!$fileContent) {
            return redirect()->back()->with('error', 'The uploaded file is empty.');
        }

        // ── 1. XLSX → CSV conversion (no external package needed) ──────────
        if (substr($fileContent, 0, 4) === "PK\x03\x04") {
            try {
                $zip = new \ZipArchive();
                if ($zip->open($rawPath) !== true) {
                    return redirect()->back()->with('error', 'Could not read the Excel file. Please make sure it is a valid .xlsx file.');
                }

                // Read shared strings (string table)
                $sharedStrings = [];
                $ssXml = $zip->getFromName('xl/sharedStrings.xml');
                if ($ssXml) {
                    $ss = simplexml_load_string($ssXml);
                    foreach ($ss->si as $si) {
                        // Each <si> may have <t> or <r><t>
                        $text = '';
                        if (isset($si->t)) {
                            $text = (string) $si->t;
                        } else {
                            foreach ($si->r as $r) {
                                $text .= (string) $r->t;
                            }
                        }
                        $sharedStrings[] = $text;
                    }
                }

                // Read first sheet (sheet1.xml)
                $sheetXml = $zip->getFromName('xl/worksheets/sheet1.xml');
                $zip->close();

                if (!$sheetXml) {
                    return redirect()->back()->with('error', 'Could not find sheet data in the Excel file.');
                }

                $sheet = simplexml_load_string($sheetXml);
                $rows = [];

                foreach ($sheet->sheetData->row as $row) {
                    $rowData = [];
                    $lastCol = 0;

                    foreach ($row->c as $cell) {
                        // Determine column index from cell ref (e.g. A1, B2, AA3)
                        preg_match('/^([A-Z]+)/', (string)$cell['r'], $colMatch);
                        $colLetters = $colMatch[1] ?? 'A';
                        $colIndex = 0;
                        foreach (str_split($colLetters) as $ch) {
                            $colIndex = $colIndex * 26 + (ord($ch) - ord('A') + 1);
                        }
                        $colIndex--; // 0-based

                        // Fill gaps with empty strings
                        while ($lastCol < $colIndex) {
                            $rowData[] = '';
                            $lastCol++;
                        }

                        // Get cell value
                        $type = (string)$cell['t'];
                        $value = (string)$cell->v;

                        if ($type === 's') {
                            // Shared string
                            $value = $sharedStrings[(int)$value] ?? '';
                        } elseif ($type === 'inlineStr') {
                            $value = (string)$cell->is->t;
                        }
                        // Numeric / date / boolean values come as-is

                        $rowData[] = $value;
                        $lastCol++;
                    }

                    $rows[] = $rowData;
                }

                // Convert rows array → CSV string
                $csvBuffer = fopen('php://memory', 'r+');
                foreach ($rows as $rowData) {
                    fputcsv($csvBuffer, $rowData);
                }
                rewind($csvBuffer);
                $fileContent = stream_get_contents($csvBuffer);
                fclose($csvBuffer);

            } catch (\Throwable $e) {
                return redirect()->back()->with('error', 'Failed to parse Excel file: ' . $e->getMessage());
            }
        }

        // ── 2. Detect & convert multi-byte encodings to UTF-8 ──────────────

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

                // 1. Product Name
                $tileName = $getCol($row, ['Product Name', 'Tile Name', 'TileName', 'Design Name', 'Name', 'Title', 'Product', 'Item Name', 'Tile'], 2);
                if (!$tileName && $getCol($row, ['Design Code'])) {
                    $tileName = 'Tile ' . $getCol($row, ['Design Code']);
                }
                
                // Skip header row if re-encountered
                if (strtolower((string)$tileName) === 'tile name' || strtolower((string)$tileName) === 'name' || strtolower((string)$tileName) === 'product name') {
                    continue;
                }

                if (!$tileName) {
                    $errors[] = "Row {$lineNumber}: Skipped - Missing product name.";
                    $failedCount++;
                    continue;
                }

                // 2. Category
                $categoryName = $getCol($row, ['Category', 'Cat'], 4);
                $categoryId = $defaultCategoryId;
                if ($categoryName) {
                    $catClean = trim($categoryName);
                    // Synonym normalization
                    if (strcasecmp($catClean, 'Taps & Valves') === 0) {
                        $catClean = 'Faucets';
                    } elseif (strcasecmp($catClean, 'Flush Plates') === 0) {
                        $catClean = 'Sanitaryware';
                    } elseif (strcasecmp($catClean, 'TILES') === 0) {
                        $catClean = 'Tiles';
                    }

                    $catSlug = Str::slug($catClean);
                    if (isset($categoriesMap[$catClean])) {
                        $categoryId = $categoriesMap[$catClean];
                    } elseif (isset($categoriesSlugMap[$catSlug])) {
                        $categoryId = $categoriesSlugMap[$catSlug];
                    } else {
                        $newCat = Category::create([
                            'name' => ucwords($catClean),
                            'slug' => $catSlug,
                            'image' => 'images/categories/tiles.svg'
                        ]);
                        $categoriesMap[$catClean] = $newCat->id;
                        $categoriesSlugMap[$catSlug] = $newCat->id;
                        $categoryId = $newCat->id;
                    }
                }

                // 3. Room / Application Area
                $appArea = $getCol($row, ['Application Area', 'ApplicationArea', 'Room', 'Application'], 21);
                if (!$appArea) {
                    if (strtoupper((string)$getCol($row, ['Bathroom'])) === 'YES') {
                        $appArea = 'Bathroom';
                    } elseif (strtoupper((string)$getCol($row, ['Kitchen'])) === 'YES') {
                        $appArea = 'Kitchen';
                    } elseif (strtoupper((string)$getCol($row, ['Living Room'])) === 'YES') {
                        $appArea = 'Living Room';
                    } elseif (strtoupper((string)$getCol($row, ['Outdoor'])) === 'YES' || strtoupper((string)$getCol($row, ['Parking'])) === 'YES') {
                        $appArea = 'Outdoor';
                    } elseif (strcasecmp((string)$categoryName, 'Sanitaryware') === 0 || strcasecmp((string)$categoryName, 'Taps & Valves') === 0 || strcasecmp((string)$categoryName, 'Faucets') === 0) {
                        $appArea = 'Bathroom';
                    }
                }

                $roomId = $defaultRoomId;
                if ($appArea) {
                    foreach ($roomsMap as $rName => $rId) {
                        if (stripos($appArea, $rName) !== false) {
                            $roomId = $rId;
                            break;
                        }
                    }
                }

                // 4. Brand
                $brandName = $getCol($row, ['Brand', 'Manufacturer', 'Supplier']);
                $brandId = $defaultBrandId;
                if ($brandName) {
                    $cleanBrand = trim($brandName);
                    if (isset($brandsMap[$cleanBrand])) {
                        $brandId = $brandsMap[$cleanBrand];
                    } else {
                        $newBrand = Brand::create([
                            'name' => $cleanBrand,
                            'slug' => Str::slug($cleanBrand)
                        ]);
                        $brandsMap[$cleanBrand] = $newBrand->id;
                        $brandId = $newBrand->id;
                    }
                }

                // 5. SKU / Product Code / Article Number / Design Code
                $sku = $getCol($row, ['SKU / Product Code', 'SKU/Product Code', 'SKU', 'Art No', 'Article Number', 'Design Code', 'Product Code', 'Supplier SKU', 'Code'], 15);
                
                // URL Slug
                $slug = $getCol($row, ['URL Slug', 'URLSlug', 'Slug'], 26);
                if (!$slug || $slug === $tileName) {
                    $slug = Str::slug($tileName);
                }

                if (!$sku || (is_numeric($sku) && (int)$sku < 100)) {
                    $sku = strtoupper(Str::slug($tileName)) . '-' . rand(1000, 9999);
                }

                // Numeric parsing helpers
                $parseNum = function($val, $default = 0) {
                    if ($val === null) return $default;
                    $clean = preg_replace('/[^0-9\.]/', '', (string)$val);
                    return is_numeric($clean) ? (float)$clean : $default;
                };

                // 6. Pricing (MRP, Selling Price, Price per Box, Price per Sq.ft)
                $mrpVal = $parseNum($getCol($row, ['MRP (Rs)', 'MRP', 'Price per Box', 'Price per box', 'Price/Box', 'Price', 'Dealer Cost'], 19), 0);
                $sellingPriceVal = $parseNum($getCol($row, ['Selling Price (Rs)', 'Selling Price', 'Recommended Selling Price', 'Offer Price']), 0);
                $pricePerSqft = $parseNum($getCol($row, ['Price per Sq.Ft', 'Price per Sq Ft', 'Price per sq.ft', 'Price per sqft', 'Rate per sq fett', 'Rate per sq ft'], 20), 0);

                $mrp = $mrpVal > 0 ? $mrpVal : ($sellingPriceVal > 0 ? $sellingPriceVal : ($pricePerSqft > 0 ? $pricePerSqft * 16 : 500));
                $price = $sellingPriceVal > 0 ? $sellingPriceVal : ($pricePerSqft > 0 ? $pricePerSqft : ($mrpVal > 0 ? $mrpVal : 50));

                // 7. Stock Status
                $stockVal = $getCol($row, ['Stock Status', 'Product Status', 'Stock status', 'Stock', 'Quantity', 'Status'], 23);
                $stock = 100;
                if ($stockVal) {
                    if (is_numeric($stockVal)) {
                        $stock = (int)$stockVal;
                    } elseif (stripos($stockVal, 'out') !== false) {
                        $stock = 0;
                    }
                }

                // 8. Specs & Dimensions
                $widthMm = $parseNum($getCol($row, ['Width (mm)', 'Width(mm)', 'Width', 'Length (mm)'], 7), 600);
                $heightMm = $parseNum($getCol($row, ['Height (mm)', 'Height(mm)', 'Height'], 8), 1200);
                $thickness = $getCol($row, ['Thickness (mm)', 'Thickness(mm)', 'Thickness'], 10) ?? '9 MM';
                $size = $getCol($row, ['Size (mm)', 'Size', 'Size(mm)', 'Variant/Size'], 9) ?? ($widthMm . 'x' . $heightMm . 'mm');
                $sizeInch = $getCol($row, ['Size (Inch)', 'Size (inch)', 'Size(inch)', 'Size (Inches)'], 11) ?? '24x48';
                $collection = $getCol($row, ['Collection', 'Collection / Series', 'Series'], 3) ?? 'Standard';

                // Sub Category
                $subCategory = $getCol($row, ['Sub Category', 'SubCategory', 'Sub-Category'], 5);
                if (!$subCategory) {
                    if (stripos($collection, 'Parking') !== false) {
                        $subCategory = 'Parking Tiles';
                    } elseif ($getCol($row, ['Product Type'])) {
                        $subCategory = $getCol($row, ['Product Type']);
                    } else {
                        $subCategory = 'General';
                    }
                }

                $finish = $getCol($row, ['Finish', 'Surface Aesthetic'], 6) ?? 'Standard';
                $patternType = $getCol($row, ['Pattern Types', 'Pattern Type', 'PatternType', 'Pattern'], 13) ?? 'Standard';
                $edgeType = $getCol($row, ['Edge Type', 'EdgeType', 'Edge'], 14) ?? 'Square';
                $piecesPerBox = (int)$parseNum($getCol($row, ['Pieces per Box', 'Pieces per box', 'Pieces/Box', 'Tiles per Box'], 16), 2);
                $coveragePerBox = $parseNum($getCol($row, ['Coverage per Box (sq.ft)', 'Coverage per Box (Sq Ft)', 'Coverage per box (sqft)', 'Coverage'], 17), 16);
                $weightPerBox = $parseNum($getCol($row, ['Weight per Box (kg/ft)', 'Weight per Box (kg)', 'Box Weight (Kg)', 'Weight'], 18), 30);
                $areaTileSqft = $parseNum($getCol($row, ['Area/Tile (sq.ft)', 'Area/Tile (sqft)', 'Area/Tile'], 12), 8);

                // Descriptions & Meta
                $shortDesc = $getCol($row, ['Short Description', 'ShortDescription', 'Description'], 24);
                $longDesc = $getCol($row, ['Long Description', 'Long Description / Bullets', 'Key Features']);
                $metaDesc = $getCol($row, ['SEO Meta Description', 'Meta Description', 'SEO Meta Title'], 25);
                $metaTitle = $getCol($row, ['SEO Meta Title', 'SEO Title', 'Meta Title']) ?? "Buy {$tileName} Online";
                $catalogPage = $getCol($row, ['Catalog Page', 'CatalogPage', 'Page'], 27);
                $tileImage = $getCol($row, ['Tile Image', 'Tile Image (Light/Var.1)', 'TileImage', 'Image', 'Image Path'], 1);

                $productData = [
                    'name' => $tileName,
                    'short_description' => $shortDesc,
                    'description' => $longDesc ?? ($shortDesc ?? "Premium quality {$tileName}."),
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

                // Automatically ensure SubCategory exists in sub_categories table
                if (!empty($subCategory) && !empty($categoryId)) {
                    SubCategory::firstOrCreate(
                        [
                            'category_id' => $categoryId,
                            'slug' => Str::slug($subCategory)
                        ],
                        [
                            'name' => $subCategory,
                            'image' => $tileImage ?: 'images/categories/tiles.svg',
                            'sort_order' => 1
                        ]
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

        if ($request->filled('sub_category') && $request->filled('category_id')) {
            SubCategory::firstOrCreate(
                [
                    'category_id' => $request->input('category_id'),
                    'slug' => Str::slug($request->input('sub_category'))
                ],
                [
                    'name' => $request->input('sub_category'),
                    'image' => $imagePath ?: 'images/categories/tiles.svg',
                    'sort_order' => 1
                ]
            );
        }

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

        if ($request->filled('sub_category') && $request->filled('category_id')) {
            SubCategory::firstOrCreate(
                [
                    'category_id' => $request->input('category_id'),
                    'slug' => Str::slug($request->input('sub_category'))
                ],
                [
                    'name' => $request->input('sub_category'),
                    'image' => $imagePath ?? 'images/categories/tiles.svg',
                    'sort_order' => 1
                ]
            );
        }

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

    /* -------------------------------------------------------------
     * CRUD: BANNERS
     * ------------------------------------------------------------- */

    public function banners()
    {
        $banners = Banner::orderBy('created_at', 'desc')->get();
        return view('admin.banners.index', compact('banners'));
    }

    public function bannerStore(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'link' => 'nullable|string|max:255',
            'image' => 'required|image|max:4096'
        ]);

        $imagePath = 'images/pristo/hero_bathroom.jpg';
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $destPath = public_path('images/banners');
            if (!file_exists($destPath)) {
                mkdir($destPath, 0755, true);
            }
            $file->move($destPath, $fileName);
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

        return redirect()->back()->with('success', 'Banner created successfully.');
    }

    public function bannerDelete($id)
    {
        $banner = Banner::findOrFail($id);
        $banner->delete();
        return redirect()->back()->with('success', 'Banner deleted successfully.');
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

