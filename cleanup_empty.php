<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Category;
use App\Models\Brand;
use App\Models\Room;
use App\Models\Product;

echo "Cleaning up empty Categories, Brands, and Rooms...\n";

// Disable foreign key checks temporarily if needed, though delete cascade or normal delete should work if they have NO products.
\Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();

$deletedCategories = Category::whereDoesntHave('products')->delete();
$deletedBrands = Brand::whereDoesntHave('products')->delete();
$deletedRooms = Room::whereDoesntHave('products')->delete();

\Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

echo "Deleted {$deletedCategories} empty Categories.\n";
echo "Deleted {$deletedBrands} empty Brands.\n";
echo "Deleted {$deletedRooms} empty Rooms.\n";

echo "Done! Now your website only has 100% REAL categories and brands based on your uploaded products.\n";
