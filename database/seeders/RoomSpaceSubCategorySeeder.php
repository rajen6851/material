<?php

namespace Database\Seeders;

use App\Models\RoomSpaceSubCategory;
use Illuminate\Database\Seeder;

class RoomSpaceSubCategorySeeder extends Seeder
{
    public function run(): void
    {
        $subCategories = [
            [
                'name' => 'Luxury Bathroom',
                'description' => 'High‑end bathroom designs with premium fixtures.',
                'image_path' => 'sub_category_images/luxury_bathroom.jpg',
                'slug' => 'luxury-bathroom',
            ],
            [
                'name' => 'Modern Kitchen',
                'description' => 'Sleek kitchen layouts with contemporary aesthetics.',
                'image_path' => 'sub_category_images/modern_kitchen.jpg',
                'slug' => 'modern-kitchen',
            ],
            [
                'name' => 'Cozy Living Room',
                'description' => 'Comfortable living spaces with warm tones.',
                'image_path' => 'sub_category_images/cozy_living_room.jpg',
                'slug' => 'cozy-living-room',
            ],
        ];

        foreach ($subCategories as $data) {
            RoomSpaceSubCategory::updateOrCreate(['slug' => $data['slug']], $data);
        }
    }
}

?>
