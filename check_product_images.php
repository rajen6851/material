<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;
use App\Models\ProductImage;

echo "Starting SMART SYNC (V3 Ultimate Version)...\n\n";

$imageDir = public_path('images/products');
if (!is_dir($imageDir)) {
    echo "Directory not found!\n";
    exit;
}

$allProducts = Product::all();

// PHASE 1: Total Clean Slate for Script Images
echo "Phase 1: Clearing old script links to fix any color/model mismatches...\n";
$deleted = ProductImage::where('image_path', 'like', 'images/products/%')->delete();
echo "Removed {$deleted} old links. Starting fresh...\n\n";

// PHASE 2: Re-Sync Images with Ultimate Logic
echo "Phase 2: Linking images using V3 Ultimate rules...\n";
$files = scandir($imageDir);

$linkedCount = 0;
$notFoundCount = 0;

foreach ($files as $file) {
    if ($file === '.' || $file === '..') continue;
    
    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
    if (!in_array($ext, ['jpeg', 'jpg', 'png', 'webp', 'gif', 'svg'])) continue;

    $actualPath = 'images/products/' . $file;
    $fileNameLower = strtolower($file);
    
    $matchedProduct = null;
    $bestMatchScore = -1;

    foreach ($allProducts as $p) {
        $skuLower = strtolower(trim($p->sku));
        $slugLower = strtolower(trim($p->slug));
        $nameLower = strtolower(trim($p->name));
        
        $isMatch = false;
        $score = 0;

        // 1. Strict SKU Match (Highest Priority)
        if (strlen($skuLower) >= 3 && preg_match('/(^|[^a-z0-9])' . preg_quote($skuLower, '/') . '([^a-z0-9]|$)/i', $fileNameLower)) {
            $isMatch = true;
            $score = 1000 + strlen($skuLower); 
        }

        // 2. Exact Product Name Match (Solves Feanza, Alone, Victoria, etc.)
        if (!$isMatch) {
            $rawName = trim(explode('(', $p->name)[0]);
            $nameWords = array_filter(explode(' ', strtolower($rawName)), function($w) { 
                return strlen($w) > 2 && $w !== 'the' && $w !== 'and'; 
            });
            
            if (count($nameWords) > 0) {
                $matchedNameWords = 0;
                foreach ($nameWords as $word) {
                    if (preg_match('/(^|[^a-z0-9])' . preg_quote($word, '/') . '([^a-z0-9]|$)/i', $fileNameLower)) {
                        $matchedNameWords++;
                    }
                }
                
                // If the entire main product name is present in the filename
                if ($matchedNameWords == count($nameWords)) {
                    $isMatch = true;
                    $currentScore = 600; // Base score for exact name match
                    
                    // Boost score based on extra words present (Differentiates Full vs Half Pedestal)
                    $slugWords = array_filter(explode('-', $slugLower), function($w) { return strlen($w) > 2; });
                    foreach ($slugWords as $word) {
                        if ($word == 'basin' && preg_match('/(^|[^a-z0-9])basins?([^a-z0-9]|$)/i', $fileNameLower)) {
                            $currentScore += 10;
                        }
                        elseif (preg_match('/(^|[^a-z0-9])' . preg_quote($word, '/') . '([^a-z0-9]|$)/i', $fileNameLower)) {
                            $currentScore += 10;
                        }
                    }
                    
                    if ($currentScore > $score) {
                        $score = $currentScore;
                    }
                }
            }
        }
        
        // 3. Strict Slug Match (Requires full match for small slugs)
        if (!$isMatch && strlen($slugLower) > 0) {
            $slugWords = array_filter(explode('-', $slugLower), function($w) { return strlen($w) > 2; });
            if (count($slugWords) > 0) {
                $matchedWords = 0;
                foreach ($slugWords as $word) {
                    if (preg_match('/(^|[^a-z0-9])' . preg_quote($word, '/') . '([^a-z0-9]|$)/i', $fileNameLower)) {
                        $matchedWords++;
                    }
                }
                
                // Prevent small slugs (like 'jupiter-green') from matching just 'green'
                $requiredMatches = count($slugWords) > 3 ? count($slugWords) - 1 : count($slugWords);
                
                if ($matchedWords > 0 && $matchedWords >= $requiredMatches) {
                    $isMatch = true;
                    if (100 + $matchedWords > $score) {
                        $score = 100 + $matchedWords;
                    }
                }
            }
        }
        
        // 4. Geberit Special Case
        if (!$isMatch && str_contains($fileNameLower, 'alpha') && (str_contains($nameLower, 'geberit') || str_contains($nameLower, 'alpha'))) {
            $fileWords = explode('_', $fileNameLower);
            $matchScore = 0;
            foreach ($fileWords as $word) {
                if (strlen($word) > 2 && preg_match('/(^|[^a-z0-9])' . preg_quote($word, '/') . '([^a-z0-9]|$)/i', $nameLower)) {
                    $matchScore++;
                }
            }
            if ($matchScore >= 3) {
                $isMatch = true;
                if (500 > $score) $score = 500;
            }
        }

        if ($isMatch && $score > $bestMatchScore) {
            $matchedProduct = $p;
            $bestMatchScore = $score;
        }
    }

    if ($matchedProduct) {
        $existingImage = ProductImage::where('product_id', $matchedProduct->id)->first();
        if ($existingImage) {
            $existingImage->image_path = $actualPath;
            $existingImage->save();
        } else {
            ProductImage::create([
                'product_id' => $matchedProduct->id,
                'image_path' => $actualPath,
                'is_primary' => true
            ]);
        }
        
        echo "LINKED: {$file}  --->  Product: {$matchedProduct->name} (SKU: {$matchedProduct->sku})\n";
        $linkedCount++;
    } else {
        $notFoundCount++;
    }
}

echo "\n========================================\n";
echo "V3 Ultimate Sync Summary\n";
echo "========================================\n";
echo "Successfully Linked Images: {$linkedCount}\n";
echo "Unmatched Files in Folder: {$notFoundCount}\n";
