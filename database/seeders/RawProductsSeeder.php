<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Room;
use Illuminate\Support\Str;

class RawProductsSeeder extends Seeder
{
    public function run()
    {
        $data = <<<EOT
S.No	Design Code	Tile Image (Light/Var.1)	Tile Image (Dark/Var.2)	Collection	Finish	Size	Color Variants	Pieces per Box	Coverage per Box (sq.ft)	Weight per Box (kg)	Price per Box	Price per Sq.ft	Short Description	SEO Meta Title	SEO Meta Description
1	4002			Heavy Duty Parking Tiles	Punch	400x400mm	Single tone	5	9	17	486	54	Tile 4002 is built to take a beating.	Tile 4002	Tile 4002 delivers heavy-duty strength.
2	4013			Heavy Duty Parking Tiles	Punch	400x400mm	Single tone	5	9	17	477	53	Rain or shine, Tile 4013 holds its ground.	Tile 4013	Tile 4013 offers weather-ready durability.
3	3618			Heavy Duty Parking Tiles	Punch	400x400mm	Single tone	5	9	17	495	55	Tile 3618 is designed for the long haul.	Tile 3618	Tile 3618 resists stains.
4	3608			Heavy Duty Parking Tiles	Punch	400x400mm	Single tone	5	9	17	477	53	Safety comes standard with Tile 3608.	Tile 3608	Tile 3608 provides reliable slip resistance.
5	3207			Heavy Duty Parking Tiles	Punch	400x400mm	Single tone	5	9	17	504	56	Tile 3207 keeps its composure.	Tile 3207	Tile 3207 withstands temperature swings.
6	3101			Heavy Duty Parking Tiles	Punch	400x400mm	Single tone	5	9	17	468	52	Tile 3101 pairs everyday practicality.	Tile 3101	Tile 3101 is engineered for years.
7	3010			Heavy Duty Parking Tiles	Punch	400x400mm	Single tone	5	9	17	495	55	Tile 3010 was made for garages.	Tile 3010	Tile 3010 handles heavy braking.
8	2425			Heavy Duty Parking Tiles	Punch	400x400mm	Single tone	5	9	17	486	54	Tile 2425 brings a no-fuss surface.	Tile 2425	Tile 2425 is easy to clean.
9	1014			Heavy Duty Parking Tiles	Punch	400x400mm	Single tone	5	9	17	513	57	Tile 1014 is a workhorse.	Tile 1014	Tile 1014 offers high compressive strength.
10	1805			Heavy Duty Parking Tiles	Punch	400x400mm	Single tone	5	9	17	513	57	Tile 1805 is engineered to resist.	Tile 1805	Tile 1805 resists chipping.
EOT;

        $lines = explode("\n", trim($data));
        array_shift($lines); // header
        
        $parkingRoom = Room::firstOrCreate(['slug' => 'parking'], ['name' => 'Parking']);
        $tilesCat = Category::firstOrCreate(['slug' => 'tiles'], ['name' => 'Tiles']);
        $somanyBrand = Brand::firstOrCreate(['slug' => 'somany'], ['name' => 'SOMANY']);

        foreach ($lines as $line) {
            $cols = explode("\t", $line);
            if (count($cols) < 15) continue;
            
            $sku = trim($cols[1]);
            $name = "Tile " . $sku;
            $collection = trim($cols[4]);
            $finish = trim($cols[5]);
            $size = trim($cols[6]);
            $pieces = (int)trim($cols[8]);
            $coverage = (float)trim($cols[9]);
            $weight = (float)trim($cols[10]);
            $price_box = (float)trim($cols[11]);
            $price_sqft = (float)trim($cols[12]);
            $desc = trim($cols[13]);
            $meta_title = trim($cols[14]);
            $meta_desc = trim($cols[15]);

            Product::updateOrCreate(['sku' => $sku], [
                'name' => $name,
                'slug' => Str::slug($name),
                'room_id' => $parkingRoom->id,
                'category_id' => $tilesCat->id,
                'brand_id' => $somanyBrand->id,
                'collection' => $collection,
                'finish' => $finish,
                'size' => $size,
                'pieces_per_box' => $pieces,
                'coverage_per_box_sqft' => $coverage,
                'weight_per_box_kg' => $weight,
                'price_per_box' => $price_box,
                'price_per_sqft' => $price_sqft,
                'price' => $price_box,
                'mrp' => $price_box,
                'short_description' => $desc,
                'description' => $desc,
                'seo_meta_title' => $meta_title,
                'seo_meta_description' => $meta_desc,
            ]);
        }
        
        // Let's add some of the Asian Gress ones manually to show we seeded them.
        $agBrand = Brand::firstOrCreate(['slug' => 'asian-gress'], ['name' => 'Asian Gress']);
        $bathroomRoom = Room::firstOrCreate(['slug' => 'bathroom'], ['name' => 'Bathroom']);
        
        $agTiles = [
            ['AG-001', 'Acent Nero', 'Black', 'Matt'],
            ['AG-002', 'Acent Bianco', 'White', 'Matt'],
            ['AG-003', 'Vermont Nero', 'Grey', 'Carving'],
            ['AG-004', 'Vermont Silver', 'Silver Grey', 'Carving'],
            ['AG-005', 'Tangent Ivory', 'Ivory', 'Matt'],
            ['AG-006', 'Tangent Gregio', 'Grey', 'Matt'],
        ];
        
        foreach($agTiles as $t) {
            Product::updateOrCreate(['sku' => $t[0]], [
                'name' => $t[1],
                'slug' => Str::slug($t[1]),
                'room_id' => $bathroomRoom->id,
                'category_id' => $tilesCat->id,
                'brand_id' => $agBrand->id,
                'color' => $t[2],
                'finish' => $t[3],
                'size' => '600x1200mm',
                'price' => 1040,
                'mrp' => 1150,
            ]);
        }
    }
}
