<?php

namespace Database\Seeders;

use App\Models\ProductAttribute;
use Illuminate\Database\Seeder;

class ProductAttributeSeeder extends Seeder
{
    public function run(): void
    {
        $attributes = [
            'collection' => ['Glossy', 'Matt', 'Sugar', 'Carving', 'High Glossy', 'Satin', 'Rustic', 'Polished', 'Lapato', 'Metallic'],
            'material' => ['Ceramic', 'Porcelain', 'Vitrified', 'Natural Stone', 'Marble', 'Granite', 'Quartz', 'Mosaic'],
            'finish' => ['Glossy', 'Matt', 'Sugar', 'Carving', 'High Glossy', 'Satin', 'Rustic', 'Polished', 'Lapato', 'Metallic', 'Anti-Skid'],
            'pattern_type' => ['Standard', 'Marble', 'Wood', 'Stone', 'Geometric', 'Floral', 'Abstract', 'Plain', 'Mosaic', 'Brick'],
            'edge_type' => ['Square', 'Rectified', 'Cushion', 'Bevelled'],
            'application_area' => ['Floor', 'Wall', 'Bathroom / Floor', 'Bathroom / Wall', 'Kitchen / Wall', 'Kitchen / Floor', 'Living Room', 'Outdoor', 'Commercial', 'Parking'],
        ];

        foreach ($attributes as $type => $values) {
            foreach ($values as $index => $value) {
                ProductAttribute::updateOrCreate(
                    ['type' => $type, 'value' => $value],
                    ['sort_order' => $index, 'is_active' => true]
                );
            }
        }
    }
}
