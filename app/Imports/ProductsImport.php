<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Str;

class ProductsImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        $headerRowIndex = -1;
        $headers = [];

        // STEP 1: Find the actual Header Row
        foreach ($rows as $index => $row) {
            // Convert the row to a string to check for keywords
            $rowString = strtolower(implode(' ', $row->toArray()));
            
            if (str_contains($rowString, 'product name') || str_contains($rowString, 'tile name') || str_contains($rowString, 'sku') || str_contains($rowString, 'article number')) {
                $headerRowIndex = $index;
                
                // Clean headers
                $headers = array_map(function($val) {
                    return strtolower(trim(preg_replace('/[^A-Za-z0-9]/', '', $val ?? '')));
                }, $row->toArray());
                break;
            }
        }

        if ($headerRowIndex === -1) return;

        // STEP 2: Process the data
        foreach ($rows as $index => $row) {
            if ($index <= $headerRowIndex) continue;
            if (collect($row)->filter()->isEmpty()) continue;

            $currentProduct = [];

            foreach ($headers as $colIndex => $headerName) {
                if (empty($headerName)) continue;

                $val = $row[$colIndex] ?? null;

                if (isset($currentProduct[$headerName])) {
                    $this->saveProduct($currentProduct);
                    $currentProduct = []; 
                }

                $currentProduct[$headerName] = $val;
            }

            if (!empty($currentProduct)) {
                $this->saveProduct($currentProduct);
            }
        }
    }

    private function saveProduct($data)
    {
        $name = $this->getValue($data, ['productname', 'tilename', 'designname', 'product']);
        $sku = $this->getValue($data, ['sku', 'productcode', 'articlenumber', 'designcode', 'skuproductcode']);
        $price = $this->getValue($data, ['mrp', 'priceperbox', 'price', 'sellingprice']);
        
        $price = preg_replace('/[^0-9.]/', '', $price ?? ''); 

        // If completely empty, skip
        if (empty($name) && empty($sku)) return; 

        if (empty($name)) {
            $name = 'Unnamed Product';
        }

        if (empty($sku)) {
            $sku = 'AUTO-SKU-' . strtoupper(uniqid()); 
        }

        $product = Product::updateOrCreate(
            ['sku' => $sku],
            [
                'name' => $name,
                'price' => !empty($price) ? (float) $price : 0,
            ]
        );
        
        // Image logic: Generate from Product Name
        $imageName = Str::slug($name) . '.jpg';
        
        // Ensure image table has the image
        $product->images()->updateOrCreate(
            ['image_path' => 'products/' . $imageName]
        );
    }

    private function getValue($data, $possibleKeys)
    {
        foreach ($possibleKeys as $key) {
            if (!empty($data[$key])) {
                return $data[$key];
            }
        }
        return null;
    }
}
