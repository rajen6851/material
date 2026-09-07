<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Room;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Coupon;
use App\Models\Banner;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Users
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '9876543210'
            ]
        );

        User::updateOrCreate(
            ['email' => 'professional@example.com'],
            [
                'name' => 'John Builders',
                'password' => Hash::make('password'),
                'role' => 'professional',
                'phone' => '9876543211',
                'professional_type' => 'builder',
                'company_name' => 'John Construction Ltd',
                'gst_number' => '27AAACJ1234D1Z5',
                'company_profile' => 'Premium home builder and contractor based in Mumbai.',
                'is_gst_verified' => true
            ]
        );

        User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
                'role' => 'homeowner',
                'phone' => '9876543212'
            ]
        );

        // 2. Ensure directories exist & write SVGs
        $this->generatePlaceholders();

        // 3. Rooms
        $roomsData = [
            ['name' => 'Bathroom', 'slug' => 'bathroom', 'image' => 'images/rooms/bathroom.svg'],
            ['name' => 'Kitchen', 'slug' => 'kitchen', 'image' => 'images/rooms/kitchen.svg'],
            ['name' => 'Living Room', 'slug' => 'living-room', 'image' => 'images/rooms/living-room.svg'],
            ['name' => 'Bedroom', 'slug' => 'bedroom', 'image' => 'images/rooms/bedroom.svg'],
            ['name' => 'Outdoor', 'slug' => 'outdoor', 'image' => 'images/rooms/outdoor.svg'],
            ['name' => 'Parking', 'slug' => 'parking', 'image' => 'images/rooms/parking.svg'],
        ];
        $rooms = [];
        foreach ($roomsData as $r) {
            $rooms[$r['slug']] = Room::updateOrCreate(['slug' => $r['slug']], $r);
        }

        // 4. Categories
        $categoriesData = [
            ['name' => 'Sanitaryware', 'slug' => 'sanitary-ware', 'image' => 'images/categories/sanitary-ware.svg'],
            ['name' => 'Wash Basins', 'slug' => 'wash-basins', 'image' => 'images/categories/wash-basins.svg'],
            ['name' => 'Faucets', 'slug' => 'faucets', 'image' => 'images/categories/faucets.svg'],
            ['name' => 'Showers', 'slug' => 'showers', 'image' => 'images/categories/showers.svg'],
            ['name' => 'Bathtubs', 'slug' => 'bathtubs', 'image' => 'images/categories/bathtubs.svg'],
            ['name' => 'Vanities & Furniture', 'slug' => 'vanities', 'image' => 'images/categories/vanities.svg'],
            ['name' => 'Bath Accessories', 'slug' => 'bath-accessories', 'image' => 'images/categories/bath-accessories.svg'],
            ['name' => 'Tiles', 'slug' => 'tiles', 'image' => 'images/categories/tiles.svg'],
            ['name' => 'Granite & Marble', 'slug' => 'granite-marble', 'image' => 'images/categories/granite-marble.svg'],
        ];
        $categories = [];
        foreach ($categoriesData as $c) {
            $categories[$c['slug']] = Category::updateOrCreate(['slug' => $c['slug']], $c);
        }

        // 5. Brands
        $brandsData = [
            ['name' => 'CERA', 'slug' => 'cera', 'logo' => 'images/brands/cera.svg', 'description' => 'Style, Hygiene and Comfort'],
            ['name' => 'JAQUAR', 'slug' => 'jaquar', 'logo' => 'images/brands/jaquar.svg', 'description' => 'Complete Bathroom & Lighting Solutions'],
            ['name' => 'KAJARIA', 'slug' => 'kajaria', 'logo' => 'images/brands/kajaria.svg', 'description' => 'India\'s No. 1 Tile Company'],
            ['name' => 'SOMANY', 'slug' => 'somany', 'logo' => 'images/brands/somany.svg', 'description' => 'Beautiful Bathrooms, Beautiful Homes'],
            ['name' => 'JOHNSON', 'slug' => 'johnson', 'logo' => 'images/brands/johnson.svg', 'description' => 'Redefining lifestyle since 1958'],
            ['name' => 'TESSA', 'slug' => 'tessa', 'logo' => 'images/brands/tessa.svg', 'description' => 'Luxury Italian Sanitaryware'],
            ['name' => 'GEBERIT', 'slug' => 'geberit', 'logo' => 'images/brands/geberit.svg', 'description' => 'Swiss Engineering for Bathrooms'],
            ['name' => 'ASIAN PAINTS', 'slug' => 'asian-paints', 'logo' => 'images/brands/asian-paints.svg', 'description' => 'Vibrant color and sanitary solutions'],
        ];
        $brands = [];
        foreach ($brandsData as $b) {
            $brands[$b['slug']] = Brand::updateOrCreate(['slug' => $b['slug']], $b);
        }

        // Disable foreign keys to truncate safely on MySQL
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        
        // 6. Banners
        Banner::truncate();
        Banner::create([
            'image' => 'images/banners/banner1.svg',
            'title' => 'Transform Your Living Spaces',
            'subtitle' => 'Premium Tiles & Marble up to 40% Off',
            'link' => '/products?category=tiles',
            'type' => 'slider',
            'is_active' => true,
        ]);

        // 7. Coupons
        Coupon::truncate();
        Coupon::create([
            'code' => 'WELCOME10',
            'type' => 'percentage',
            'value' => 10.00,
            'min_order_amount' => 1000.00,
            'expires_at' => now()->addDays(30),
            'is_active' => true,
        ]);

        // 8. Products from Spreadsheet format (Exactly as user screenshot)
        Product::truncate();
        ProductImage::truncate();

        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        $productsData = [
            [
                'name' => 'Wall Hung WC',
                'sku' => 'WC-WALL-HUNG-01',
                'description' => 'Rimless Wall Hung WC with Soft Close Seat Cover and Concealed Fixing.',
                'short_description' => 'Premium CERA Rimless Wall Hung WC.',
                'mrp' => 22000.00,
                'price' => 18990.00,
                'discount' => 13.00,
                'gst_percent' => 18.00,
                'stock' => 120,
                'rating' => 4.9,
                'is_featured' => true,
                'is_trending' => true,
                'is_new' => true,
                'room_slug' => 'bathroom',
                'category_slug' => 'sanitary-ware',
                'brand_slug' => 'cera',
                'sub_category' => 'Wall Hung WC',
                'images' => ['images/pristo/prod_wall_hung_wc.svg']
            ],
            [
                'name' => 'Single Lever Basin Mixer',
                'sku' => 'JAQ-BASIN-MIX-02',
                'description' => 'Architectural Single Lever Basin Mixer with 450mm Long Flexible Hose.',
                'short_description' => 'Jaquar Designer Single Lever Basin Mixer.',
                'mrp' => 15000.00,
                'price' => 12480.00,
                'discount' => 16.00,
                'gst_percent' => 18.00,
                'stock' => 90,
                'rating' => 4.8,
                'is_featured' => true,
                'is_trending' => true,
                'is_new' => true,
                'room_slug' => 'bathroom',
                'category_slug' => 'faucets',
                'brand_slug' => 'jaquar',
                'sub_category' => 'Basin Mixers',
                'images' => ['images/pristo/prod_basin_mixer.svg']
            ],
            [
                'name' => 'Table Top Wash Basin',
                'sku' => 'TES-TABLE-BASIN-03',
                'description' => 'Luxury Ceramic Table Top Basin with Italian Matte Glaze.',
                'short_description' => 'Tessa Table Top Countertop Wash Basin.',
                'mrp' => 11500.00,
                'price' => 8990.00,
                'discount' => 21.00,
                'gst_percent' => 18.00,
                'stock' => 60,
                'rating' => 4.9,
                'is_featured' => true,
                'is_trending' => true,
                'is_new' => true,
                'room_slug' => 'bathroom',
                'category_slug' => 'wash-basins',
                'brand_slug' => 'tessa',
                'sub_category' => 'Table Top Basin',
                'images' => ['images/pristo/prod_table_top_basin.svg']
            ],
            [
                'name' => 'Shower System',
                'sku' => 'GEB-SHOWER-SYS-04',
                'description' => 'Thermostatic Shower Column with Overhead Rain Shower & Multi-function Hand Shower.',
                'short_description' => 'Geberit Swiss Luxury Thermostatic Rain Shower System.',
                'mrp' => 31000.00,
                'price' => 25990.00,
                'discount' => 16.00,
                'gst_percent' => 18.00,
                'stock' => 40,
                'rating' => 5.0,
                'is_featured' => true,
                'is_trending' => true,
                'is_new' => true,
                'room_slug' => 'bathroom',
                'category_slug' => 'showers',
                'brand_slug' => 'geberit',
                'sub_category' => 'Shower Systems',
                'images' => ['images/pristo/prod_shower_system.svg']
            ],
            [
                'name' => 'Porcelain Tile 600x1200',
                'sku' => 'KAJ-PORCELAIN-6012',
                'description' => 'High Gloss GVT Porcelain Slab Tile with Micro Marble Veins.',
                'short_description' => 'Kajaria 600x1200mm Luxury Porcelain Tile.',
                'mrp' => 1600.00,
                'price' => 1290.00,
                'discount' => 19.00,
                'gst_percent' => 18.00,
                'stock' => 500,
                'rating' => 4.9,
                'is_featured' => true,
                'is_trending' => true,
                'is_new' => true,
                'room_slug' => 'bathroom',
                'category_slug' => 'tiles',
                'brand_slug' => 'kajaria',
                'sub_category' => 'Floor Tiles',
                'images' => ['images/pristo/prod_porcelain_tile.svg']
            ],
            [
                'name' => 'Vanity Unit',
                'sku' => 'PRS-VANITY-UNIT-06',
                'description' => 'Waterproof Solid Wood Bathroom Vanity Cabinet with Smart LED Touch Mirror.',
                'short_description' => 'Pristo Luxury Wall Hung LED Vanity Cabinet Unit.',
                'mrp' => 42000.00,
                'price' => 32990.00,
                'discount' => 21.00,
                'gst_percent' => 18.00,
                'stock' => 25,
                'rating' => 5.0,
                'is_featured' => true,
                'is_trending' => true,
                'is_new' => true,
                'room_slug' => 'bathroom',
                'category_slug' => 'vanities',
                'brand_slug' => 'tessa',
                'sub_category' => 'Vanity Cabinets',
                'images' => ['images/pristo/prod_vanity_unit.svg']
            ],
            [
                'name' => 'Emesa White',
                'sku' => 'EMESA-1200W',
                'description' => 'Craft a statement with Emesa White, blending crisp white tones with a Glossy finish in a Standard pattern, sized 600x1200mm.',
                'short_description' => 'Emesa White GVT Glossy slab tile.',
                'mrp' => 880.00,
                'price' => 55.00,
                'discount' => 0.00,
                'gst_percent' => 18.00,
                'stock' => 250,
                'rating' => 4.9,
                'is_featured' => true,
                'is_trending' => true,
                'is_new' => true,
                'room_slug' => 'bathroom',
                'category_slug' => 'tiles',
                'brand_slug' => 'kajaria',
                'size' => '600x1200 mm',
                'color' => 'White',
                'finish' => 'Glossy',
                'material' => 'GVT',
                'thickness' => '9 mm',
                'coverage_area' => '16 sq. ft / box',
                'water_absorption' => '< 0.05%',
                'warranty' => '5 Years',
                'delivery_time' => '3-5 Days',
                'collection' => 'Glossy',
                'sub_category' => 'Floor Tiles',
                'width_mm' => 600,
                'height_mm' => 1200,
                'size_inch' => '24x48',
                'area_tile_sqft' => 8.00,
                'pattern_type' => 'Standard',
                'edge_type' => 'Square',
                'pieces_per_box' => 2,
                'coverage_per_box_sqft' => 16.00,
                'weight_per_box_kg' => 30.00,
                'price_per_box' => 880.00,
                'price_per_sqft' => 55.00,
                'application_area' => 'Bathroom / Floor',
                'seo_meta_title' => 'Complete Your Space With Emesa White Glossy Tile Online',
                'seo_meta_description' => 'Now available: Emesa White - crisp white tones, Glossy finish, Standard pattern, sized 600x1200mm.',
                'catalog_page' => '1',
                'images' => ['images/products/emesa-white.svg']
            ],
            [
                'name' => 'Satvario Bronz',
                'sku' => 'SATVARIO-1200B',
                'description' => 'Frame your space with Satvario Bronz - a rich brown tile with a Glossy finish and Standard pattern, available in 600x1200mm.',
                'short_description' => 'Satvario Bronz GVT Glossy slab tile.',
                'mrp' => 880.00,
                'price' => 55.00,
                'discount' => 0.00,
                'gst_percent' => 18.00,
                'stock' => 180,
                'rating' => 4.7,
                'is_featured' => true,
                'is_trending' => true,
                'is_new' => true,
                'room_slug' => 'living-room',
                'category_slug' => 'tiles',
                'brand_slug' => 'somany',
                'size' => '600x1200 mm',
                'color' => 'Brown',
                'finish' => 'Glossy',
                'material' => 'GVT',
                'thickness' => '9 mm',
                'coverage_area' => '16 sq. ft / box',
                'water_absorption' => '< 0.05%',
                'warranty' => '5 Years',
                'delivery_time' => '3-5 Days',
                'collection' => 'Glossy',
                'sub_category' => 'Floor Tiles',
                'width_mm' => 600,
                'height_mm' => 1200,
                'size_inch' => '24x48',
                'area_tile_sqft' => 8.00,
                'pattern_type' => 'Standard',
                'edge_type' => 'Square',
                'pieces_per_box' => 2,
                'coverage_per_box_sqft' => 16.00,
                'weight_per_box_kg' => 30.00,
                'price_per_box' => 880.00,
                'price_per_sqft' => 55.00,
                'application_area' => 'Living Room / Floor',
                'seo_meta_title' => 'Style With Satvario Bronz Glossy Tile Online',
                'seo_meta_description' => 'Rich Satvario Bronz - a rich brown Glossy Finish Standard tile in 600x1200mm.',
                'catalog_page' => '2',
                'images' => ['images/products/satvario-bronz.svg']
            ],
            [
                'name' => 'Rosalia Brown',
                'sku' => 'ROSALIA-1200B',
                'description' => 'Style your space with Rosalia Brown, styled in rich brown hues with Glossy craftsmanship and a Standard pattern.',
                'short_description' => 'Rosalia Brown GVT Glossy slab tile.',
                'mrp' => 801.00,
                'price' => 54.00,
                'discount' => 0.00,
                'gst_percent' => 18.00,
                'stock' => 150,
                'rating' => 4.6,
                'is_featured' => true,
                'is_trending' => false,
                'is_new' => false,
                'room_slug' => 'kitchen',
                'category_slug' => 'tiles',
                'brand_slug' => 'johnson',
                'size' => '600x1200 mm',
                'color' => 'Brown',
                'finish' => 'Glossy',
                'material' => 'GVT',
                'thickness' => '9 mm',
                'coverage_area' => '16 sq. ft / box',
                'water_absorption' => '< 0.05%',
                'warranty' => '5 Years',
                'delivery_time' => '3-5 Days',
                'collection' => 'Glossy',
                'sub_category' => 'Wall Tiles',
                'width_mm' => 600,
                'height_mm' => 1200,
                'size_inch' => '24x48',
                'area_tile_sqft' => 8.00,
                'pattern_type' => 'Standard',
                'edge_type' => 'Square',
                'pieces_per_box' => 2,
                'coverage_per_box_sqft' => 16.00,
                'weight_per_box_kg' => 30.00,
                'price_per_box' => 801.00,
                'price_per_sqft' => 54.00,
                'application_area' => 'Kitchen / Wall',
                'seo_meta_title' => 'Buy Rosalia Brown Glossy Tile Online',
                'seo_meta_description' => 'Meet Rosalia Brown featuring rich brown styling and a Glossy finish in Standard pattern, 600x1200mm.',
                'catalog_page' => '3',
                'images' => ['images/products/rosalia-brown.svg']
            ],
            [
                'name' => 'Rock Silver',
                'sku' => 'ROCK-1200S',
                'description' => 'Highlight elegance with Rock Silver, styled in cool silver hues with Glossy craftsmanship and a Standard pattern.',
                'short_description' => 'Rock Silver GVT Glossy slab tile.',
                'mrp' => 880.00,
                'price' => 55.00,
                'discount' => 0.00,
                'gst_percent' => 18.00,
                'stock' => 310,
                'rating' => 4.8,
                'is_featured' => true,
                'is_trending' => true,
                'is_new' => true,
                'room_slug' => 'outdoor',
                'category_slug' => 'tiles',
                'brand_slug' => 'asian-paints',
                'size' => '600x1200 mm',
                'color' => 'Grey',
                'finish' => 'Glossy',
                'material' => 'GVT',
                'thickness' => '9 mm',
                'coverage_area' => '16 sq. ft / box',
                'water_absorption' => '< 0.05%',
                'warranty' => '5 Years',
                'delivery_time' => '3-5 Days',
                'collection' => 'Glossy',
                'sub_category' => 'Outdoor Tiles',
                'width_mm' => 600,
                'height_mm' => 1200,
                'size_inch' => '24x48',
                'area_tile_sqft' => 8.00,
                'pattern_type' => 'Standard',
                'edge_type' => 'Square',
                'pieces_per_box' => 2,
                'coverage_per_box_sqft' => 16.00,
                'weight_per_box_kg' => 30.00,
                'price_per_box' => 880.00,
                'price_per_sqft' => 55.00,
                'application_area' => 'Outdoor / Floor',
                'seo_meta_title' => 'Transform With Rock Silver Glossy Tile Online',
                'seo_meta_description' => 'Browse Rock Silver featuring cool silver styling and a Glossy finish in Standard pattern, 600x1200mm.',
                'catalog_page' => '4',
                'images' => ['images/products/rock-silver.svg']
            ],
            [
                'name' => 'Rock Black',
                'sku' => 'ROCK-1200B',
                'description' => 'Transform your space with Rock Black - a bold black tile with a Glossy finish and Standard pattern.',
                'short_description' => 'Rock Black GVT Glossy slab tile.',
                'mrp' => 880.00,
                'price' => 55.00,
                'discount' => 0.00,
                'gst_percent' => 18.00,
                'stock' => 200,
                'rating' => 4.9,
                'is_featured' => true,
                'is_trending' => true,
                'is_new' => true,
                'room_slug' => 'bedroom',
                'category_slug' => 'tiles',
                'brand_slug' => 'kajaria',
                'size' => '600x1200 mm',
                'color' => 'Black',
                'finish' => 'Glossy',
                'material' => 'GVT',
                'thickness' => '9 mm',
                'coverage_area' => '16 sq. ft / box',
                'water_absorption' => '< 0.05%',
                'warranty' => '5 Years',
                'delivery_time' => '3-5 Days',
                'collection' => 'Glossy',
                'sub_category' => 'Floor Tiles',
                'width_mm' => 600,
                'height_mm' => 1200,
                'size_inch' => '24x48',
                'area_tile_sqft' => 8.00,
                'pattern_type' => 'Standard',
                'edge_type' => 'Square',
                'pieces_per_box' => 2,
                'coverage_per_box_sqft' => 16.00,
                'weight_per_box_kg' => 30.00,
                'price_per_box' => 880.00,
                'price_per_sqft' => 55.00,
                'application_area' => 'Bedroom / Floor',
                'seo_meta_title' => 'Personalize With Rock Black - Glossy 600x600',
                'seo_meta_description' => 'Shop Rock Black - bold black tones, Glossy finish, Standard pattern, sized 600x1200mm.',
                'catalog_page' => '5',
                'images' => ['images/products/rock-black.svg']
            ],
            [
                'name' => 'Oliva Real',
                'sku' => 'OLIVA-1200R',
                'description' => 'Shape your interiors with Oliva Real, styled in refined neutral hues with Glossy craftsmanship.',
                'short_description' => 'Oliva Real GVT Glossy slab tile.',
                'mrp' => 928.00,
                'price' => 58.00,
                'discount' => 0.00,
                'gst_percent' => 18.00,
                'stock' => 120,
                'rating' => 4.8,
                'is_featured' => true,
                'is_trending' => true,
                'is_new' => true,
                'room_slug' => 'parking',
                'category_slug' => 'tiles',
                'brand_slug' => 'somany',
                'size' => '600x1200 mm',
                'color' => 'Beige',
                'finish' => 'Glossy',
                'material' => 'GVT',
                'thickness' => '9 mm',
                'coverage_area' => '16 sq. ft / box',
                'water_absorption' => '< 0.05%',
                'warranty' => '5 Years',
                'delivery_time' => '3-5 Days',
                'collection' => 'Glossy',
                'sub_category' => 'Parking Tiles',
                'width_mm' => 600,
                'height_mm' => 1200,
                'size_inch' => '24x48',
                'area_tile_sqft' => 8.00,
                'pattern_type' => 'Standard',
                'edge_type' => 'Square',
                'pieces_per_box' => 2,
                'coverage_per_box_sqft' => 16.00,
                'weight_per_box_kg' => 30.00,
                'price_per_box' => 928.00,
                'price_per_sqft' => 58.00,
                'application_area' => 'Parking / Floor',
                'seo_meta_title' => 'Try Oliva Real Standard Tile - 600x1200mm',
                'seo_meta_description' => 'Unveiling Oliva Real - refined neutral tones, Glossy finish, Standard pattern.',
                'catalog_page' => '6',
                'images' => ['images/products/oliva-real.svg']
            ]
        ];

        foreach ($productsData as $p) {
            $room = $rooms[$p['room_slug']];
            $cat = $categories[$p['category_slug']];
            $brand = $brands[$p['brand_slug']];

            unset($p['room_slug']);
            unset($p['category_slug']);
            unset($p['brand_slug']);
            $images = $p['images'];
            unset($p['images']);

            $p['room_id'] = $room->id;
            $p['category_id'] = $cat->id;
            $p['brand_id'] = $brand->id;
            $p['slug'] = Str::slug($p['name']);

            $product = Product::updateOrCreate(['sku' => $p['sku']], $p);

            foreach ($images as $index => $img) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $img,
                    'is_primary' => $index === 0
                ]);
            }
        }
        $this->call(RoomSpaceSubCategorySeeder::class);
    }

    /**
     * Generate high-quality SVG placeholders for local development.
     */
    private function generatePlaceholders(): void
    {
        $baseDir = public_path('images');

        // Create directories
        File::ensureDirectoryExists($baseDir);
        File::ensureDirectoryExists($baseDir . '/categories');
        File::ensureDirectoryExists($baseDir . '/rooms');
        File::ensureDirectoryExists($baseDir . '/brands');
        File::ensureDirectoryExists($baseDir . '/products');
        File::ensureDirectoryExists($baseDir . '/banners');

        // Helper to write SVG
        $writeSvg = function($path, $title, $bgGradientStart, $bgGradientEnd, $textColor = '#ffffff') {
            $svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 800 600" width="100%" height="100%">
  <defs>
    <linearGradient id="grad" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" style="stop-color:' . $bgGradientStart . ';stop-opacity:1" />
      <stop offset="100%" style="stop-color:' . $bgGradientEnd . ';stop-opacity:1" />
    </linearGradient>
    <filter id="shadow">
      <feDropShadow dx="2" dy="2" stdDeviation="4" flood-color="#000000" flood-opacity="0.3"/>
    </filter>
  </defs>
  <rect width="100%" height="100%" fill="url(#grad)" />
  <rect x="20" y="20" width="760" height="560" fill="none" stroke="' . $textColor . '" stroke-width="1.5" stroke-opacity="0.2" rx="8" />
  
  <circle cx="700" cy="100" r="150" fill="' . $textColor . '" fill-opacity="0.05" />
  <circle cx="100" cy="500" r="100" fill="' . $textColor . '" fill-opacity="0.03" />
  <polygon points="120,40 180,90 100,120" fill="' . $textColor . '" fill-opacity="0.04" />
  
  <g transform="translate(400, 300)">
    <text text-anchor="middle" fill="' . $textColor . '" font-family="\'Montserrat\', \'Segoe UI\', sans-serif" font-weight="800" font-size="44" filter="url(#shadow)" letter-spacing="1">' . htmlspecialchars($title) . '</text>
    <text text-anchor="middle" y="55" fill="' . $textColor . '" fill-opacity="0.7" font-family="\'Segoe UI\', sans-serif" font-weight="400" font-size="20">Premium Building Materials</text>
    
    <line x1="-80" y1="20" x2="80" y2="20" stroke="' . $textColor . '" stroke-width="3" stroke-linecap="round" stroke-opacity="0.8" />
  </g>
</svg>';
            File::put($path, $svg);
        };

        // Banners
        $writeSvg($baseDir . '/banners/banner1.svg', 'Transform Your Living Spaces', '#0f172a', '#1e293b');

        // Rooms
        $writeSvg($baseDir . '/rooms/bathroom.svg', 'Bathroom Collection', '#115e59', '#134e4a');
        $writeSvg($baseDir . '/rooms/kitchen.svg', 'Kitchen Collection', '#9a3412', '#7c2d12');
        $writeSvg($baseDir . '/rooms/living-room.svg', 'Living Room Collection', '#1e3a8a', '#172554');
        $writeSvg($baseDir . '/rooms/bedroom.svg', 'Bedroom Collection', '#581c87', '#3b0764');
        $writeSvg($baseDir . '/rooms/outdoor.svg', 'Outdoor & Balcony', '#166534', '#14532d');
        $writeSvg($baseDir . '/rooms/parking.svg', 'Parking & Driveway', '#374151', '#1f2937');

        // Categories
        $writeSvg($baseDir . '/categories/tiles.svg', 'Premium Tiles', '#1e293b', '#0f172a');
        $writeSvg($baseDir . '/categories/sanitary-ware.svg', 'Sanitary Ware', '#0f766e', '#115e59');
        $writeSvg($baseDir . '/categories/faucets.svg', 'Designer Faucets', '#a21caf', '#86198f');
        $writeSvg($baseDir . '/categories/bath-accessories.svg', 'Bath Accessories', '#0369a1', '#075985');
        $writeSvg($baseDir . '/categories/granite-marble.svg', 'Granite & Marble', '#653b08', '#451a03');

        // Brands
        $writeSvg($baseDir . '/brands/kajaria.svg', 'KAJARIA', '#ffffff', '#e2e8f0', '#0f172a');
        $writeSvg($baseDir . '/brands/somany.svg', 'SOMANY', '#ffffff', '#e2e8f0', '#0f172a');
        $writeSvg($baseDir . '/brands/johnson.svg', 'JOHNSON', '#ffffff', '#e2e8f0', '#0f172a');
        $writeSvg($baseDir . '/brands/asian-paints.svg', 'ASIAN PAINTS', '#ffffff', '#e2e8f0', '#0f172a');

        // Products
        $writeSvg($baseDir . '/products/emesa-white.svg', 'Emesa White 600x1200', '#0f172a', '#334155');
        $writeSvg($baseDir . '/products/satvario-bronz.svg', 'Satvario Bronz 600x1200', '#7c2d12', '#9a3412');
        $writeSvg($baseDir . '/products/rosalia-brown.svg', 'Rosalia Brown 600x1200', '#653b08', '#854d0e');
        $writeSvg($baseDir . '/products/rock-silver.svg', 'Rock Silver 600x1200', '#374151', '#1f2937');
        $writeSvg($baseDir . '/products/rock-black.svg', 'Rock Black 600x1200', '#111827', '#1f2937');
        $writeSvg($baseDir . '/products/oliva-real.svg', 'Oliva Real 600x1200', '#115e59', '#134e4a');
    }
}
