<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SubCategorySeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'Tiles' => [
                'Floor Tiles',
                'Wall Tiles',
                'Parking Tiles',
                'Outdoor Tiles',
                'Elevation Tiles',
            ],
            'Sanitaryware' => [
                'Wash Basins',
                'One Piece WC',
                'Wall Hung WC',
                'Floor Mounted WC',
                'Urinals',
                'Cisterns',
                'Flush Plates',
            ],
            'Bathware' => [
                'Faucets',
                'Showers',
                'Health Faucets',
                'Mixers',
            ],
            'Bathroom Accessories' => [],
            'Kitchen' => [
                'Kitchen Sink',
                'Kitchen Faucets',
            ],
        ];

        foreach ($data as $categoryName => $subCategories) {
            // Create category if not exists
            $category = Category::firstOrCreate(
                ['slug' => Str::slug($categoryName)],
                ['name' => $categoryName, 'image' => 'images/categories/tiles.svg']
            );

            foreach ($subCategories as $index => $subName) {
                SubCategory::updateOrCreate(
                    ['slug' => Str::slug($subName)],
                    [
                        'category_id' => $category->id,
                        'name' => $subName,
                        'image' => $category->image,
                        'sort_order' => $index,
                    ]
                );
            }
        }
    }
}
