<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Str;

$imageDir = public_path('images/products');

if (!is_dir($imageDir)) {
    echo "Directory does not exist: $imageDir\n";
    exit;
}

$files = scandir($imageDir);
$updatedCount = 0;
$notFoundCount = 0;

foreach ($files as $file) {
    if ($file === '.' || $file === '..') continue;
    
    // Ignore non-image files
    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
    if (!in_array($ext, ['jpeg', 'jpg', 'png', 'webp'])) continue;

    $filenameWithoutExt = pathinfo($file, PATHINFO_FILENAME);
    
    // Convert to lowercase and replace underscores/spaces with hyphens to match our DB slugs
    $normalizedSlug = Str::slug(str_replace('_', '-', $filenameWithoutExt));
    
    // Try to find the product matching this slug
    $product = Product::where('slug', $normalizedSlug)
                      ->orWhere('sku', $filenameWithoutExt)
                      ->first();
                      
    if (!$product) {
        // Fallback: Try matching exactly against sku by removing hyphens
        $product = Product::where('sku', str_replace('_', '-', $filenameWithoutExt))->first();
    }

    if ($product) {
        $actualPath = 'images/products/' . $file;
        
        // Find existing primary image record or create one
        $productImage = ProductImage::where('product_id', $product->id)->where('is_primary', true)->first();
        
        if ($productImage) {
            $productImage->image_path = $actualPath;
            $productImage->save();
        } else {
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $actualPath,
                'is_primary' => true
            ]);
        }
        
        echo "Linked image {$file} to product: {$product->name}\n";
        $updatedCount++;
    } else {
        echo "Could not find a matching product for image: {$file}\n";
        $notFoundCount++;
    }
}

echo "\n--- Summary ---\n";
echo "Successfully updated database for $updatedCount images.\n";
if ($notFoundCount > 0) {
    echo "Could not match $notFoundCount images to any product.\n";
}
