<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;

$products = Product::where('name', 'like', '%DECOR%1012%')->get();
foreach ($products as $p) {
    echo "ID: {$p->id} | Name: {$p->name} | SKU: {$p->sku} | Slug: {$p->slug}\n";
}
