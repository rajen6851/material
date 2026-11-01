<?php

echo "=== Updating Package Feature ONLY ===\n";

// 1. Update routes/web.php if needed
$webRoutesPath = __DIR__ . '/routes/web.php';
if (file_exists($webRoutesPath)) {
    $routesContent = file_get_contents($webRoutesPath);
    if (strpos($routesContent, 'PackageController') === false) {
        $routesSnippet = "\n\n" .
            "// Bathroom Packages Feature Routes\n" .
            "use App\Http\Controllers\Admin\PackageController as AdminPackageController;\n" .
            "use App\Http\Controllers\Public\PackageController as PublicPackageController;\n\n" .
            "Route::get('/packages', [PublicPackageController::class, 'index'])->name('packages.index');\n" .
            "Route::get('/packages/{slug}', [PublicPackageController::class, 'show'])->name('packages.show');\n\n" .
            "Route::middleware('auth')->group(function () {\n" .
            "    Route::get('/admin/packages', [AdminPackageController::class, 'index'])->name('admin.packages.index');\n" .
            "    Route::get('/admin/packages/create', [AdminPackageController::class, 'create'])->name('admin.packages.create');\n" .
            "    Route::post('/admin/packages', [AdminPackageController::class, 'store'])->name('admin.packages.store');\n" .
            "    Route::get('/admin/packages/{id}/edit', [AdminPackageController::class, 'edit'])->name('admin.packages.edit');\n" .
            "    Route::put('/admin/packages/{id}', [AdminPackageController::class, 'update'])->name('admin.packages.update');\n" .
            "    Route::post('/admin/packages/{id}/toggle', [AdminPackageController::class, 'toggle'])->name('admin.packages.toggle');\n" .
            "    Route::delete('/admin/packages/{id}', [AdminPackageController::class, 'destroy'])->name('admin.packages.destroy');\n" .
            "    Route::post('/admin/packages/{packageId}/items', [AdminPackageController::class, 'storeItem'])->name('admin.packages.items.store');\n" .
            "    Route::post('/admin/packages/{packageId}/bulk-add-products', [AdminPackageController::class, 'bulkAddProducts'])->name('admin.packages.items.bulk-add');\n" .
            "    Route::put('/admin/packages/items/{itemId}', [AdminPackageController::class, 'updateItem'])->name('admin.packages.items.update');\n" .
            "    Route::post('/admin/packages/items/{itemId}/area', [AdminPackageController::class, 'updateItemArea'])->name('admin.packages.items.update-area');\n" .
            "    Route::delete('/admin/packages/items/{itemId}', [AdminPackageController::class, 'destroyItem'])->name('admin.packages.items.destroy');\n" .
            "    Route::get('/admin/packages/search-products', [AdminPackageController::class, 'searchProducts'])->name('admin.packages.search-products');\n" .
            "});\n";

        file_put_contents($webRoutesPath, $routesContent . $routesSnippet);
        echo "[OK] Package routes added to routes/web.php\n";
    } else {
        if (strpos($routesContent, 'admin.packages.items.update-area') === false) {
            $routesContent = str_replace(
                "Route::put('/admin/packages/items/{itemId}', [AdminPackageController::class, 'updateItem'])->name('admin.packages.items.update');",
                "Route::put('/admin/packages/items/{itemId}', [AdminPackageController::class, 'updateItem'])->name('admin.packages.items.update');\n    Route::post('/admin/packages/items/{itemId}/area', [AdminPackageController::class, 'updateItemArea'])->name('admin.packages.items.update-area');",
                $routesContent
            );
            file_put_contents($webRoutesPath, $routesContent);
            echo "[OK] Added update-area route to routes/web.php\n";
        } else {
            echo "[INFO] Package routes already present in routes/web.php\n";
        }
    }
}

// 2. Update Brand.php if needed
$brandPath = __DIR__ . '/app/Models/Brand.php';
if (file_exists($brandPath)) {
    $brandContent = file_get_contents($brandPath);
    if (strpos($brandContent, 'packages()') === false) {
        $brandRelation = "    public function packages()\n    {\n        return \$this->hasMany(\\App\\Models\\Package::class);\n    }\n}\n";
        $brandContent = preg_replace('/\}\s*$/', $brandRelation, trim($brandContent));
        file_put_contents($brandPath, $brandContent);
        echo "[OK] packages() relationship added to app/Models/Brand.php\n";
    }
}

// 3. Update admin sidebar in resources/views/layouts/admin.blade.php if needed
$adminLayoutPath = __DIR__ . '/resources/views/layouts/admin.blade.php';
if (file_exists($adminLayoutPath)) {
    $adminContent = file_get_contents($adminLayoutPath);
    // Fix any broken tags if previously inserted
    $adminContent = preg_replace('/<a\s+<a\s+href="\{\{\s*route\(\'admin\.packages\.index\'\)\s*\}\}"/s', '<a href="{{ route(\'admin.packages.index\') }}"', $adminContent);
    $adminContent = preg_replace('/(<\/a>\s+)(href="\/admin\/brands")/s', '$1<a $2', $adminContent);
    
    if (strpos($adminContent, 'admin.packages.index') === false) {
        $needle = '<a href="/admin/brands"';
        $insert = "<a href=\"{{ route('admin.packages.index') }}\" class=\"w-full py-2 pl-8 rounded-lg transition flex items-center gap-2 {{ request()->is('admin/packages*') ? 'text-teal-400 font-bold bg-slate-800/50' : 'text-slate-300 hover:text-white hover:bg-slate-800/30' }}\">\n" .
                  "    <span>&bull; Packages / Combos</span>\n" .
                  "</a>\n                            ";
        if (strpos($adminContent, $needle) !== false) {
            $adminContent = str_replace($needle, $insert . $needle, $adminContent);
            echo "[OK] Packages link added to admin sidebar\n";
        }
    }
    file_put_contents($adminLayoutPath, $adminContent);
}

// 4. Update website header in resources/views/layouts/app.blade.php if needed
$appLayoutPath = __DIR__ . '/resources/views/layouts/app.blade.php';
if (file_exists($appLayoutPath)) {
    $appContent = file_get_contents($appLayoutPath);
    // Fix any broken tags if previously inserted
    $appContent = preg_replace('/<a\s+<a\s+href="\/packages"/s', '<a href="/packages"', $appContent);
    $appContent = preg_replace('/(<\/a>\s+)(href="\/inspiration")/s', '$1<a $2', $appContent);

    if (strpos($appContent, 'href="/packages"') === false) {
        $needle = '<a href="/inspiration"';
        $insert = "<a href=\"/packages\" class=\"hover:text-[#c09b5a] transition py-1 flex items-center gap-1.5 text-[#171615]\">\n" .
                  "    <span>Packages</span>\n" .
                  "    <span class=\"text-[9px] bg-[#c09b5a] text-white px-1.5 py-0.5 rounded-full font-bold uppercase tracking-wider\">Combos</span>\n" .
                  "</a>\n\n                    ";
        if (strpos($appContent, $needle) !== false) {
            $appContent = str_replace($needle, $insert . $needle, $appContent);
            echo "[OK] Packages link added to website navigation\n";
        }
    }
    file_put_contents($appLayoutPath, $appContent);
}

// 5. Run Migration
echo "\n--- Running Migrations ---\n";
passthru('php artisan migrate --force');

// 6. Run Package Seeder
echo "\n--- Seeding CERA Packages Data ---\n";
passthru('php artisan db:seed --class=PackageSeeder --force');

// 7. Clear view and route caches
echo "\n--- Clearing Cache ---\n";
passthru('php artisan optimize:clear');

echo "\n=== ALL DONE! Package feature is now live without touching your existing live files! ===\n";
