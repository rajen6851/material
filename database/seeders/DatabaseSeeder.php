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

        $productsData = [];

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
