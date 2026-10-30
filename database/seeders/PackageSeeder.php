<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;
use App\Models\Package;
use App\Models\PackageItem;
use Illuminate\Support\Str;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ensure CERA Brand exists
        $cera = Brand::firstOrCreate(
            ['slug' => 'cera'],
            [
                'name' => 'CERA',
                'description' => 'Sanitaryware, Faucets & Wellness solutions by Cera Sanitaryware Ltd.'
            ]
        );

        $packagesData = [
            [
                'name' => 'Configuration 1',
                'slug' => 'configuration-1',
                'brand_id' => $cera->id,
                'tagline' => 'Essential Victorian Bathroom Suite with Wall Hung Basin & Overhead Shower',
                'description' => 'Complete CERA bathroom package featuring Victor series CP brassware, Clairdell wall hung basin, and Cavall EWC with soft close seat cover.',
                'image' => 'images/packages/cera_brochure.jpg',
                'price' => 18990.00,
                'mrp' => 24500.00,
                'sort_order' => 1,
                'is_active' => true,
                'items' => [
                    // Basin Area
                    [
                        'area' => 'Basin Area',
                        'cat_no' => 'F1015101',
                        'name' => 'VICTOR - Pillar Cock with Aerator',
                        'description' => 'Single hole deck mounted chrome pillar tap with water saving aerator',
                        'price' => 1250.00,
                        'sort_order' => 1,
                    ],
                    [
                        'area' => 'Basin Area',
                        'cat_no' => 'S1040166',
                        'name' => 'CLAIRDEL - Wall Hung Basin',
                        'description' => '405 x 325 x 145 mm premium ceramic glazed basin',
                        'price' => 2200.00,
                        'sort_order' => 2,
                    ],
                    [
                        'area' => 'Basin Area',
                        'cat_no' => 'F8050101',
                        'name' => 'Waste Coupling (Half Thread)',
                        'description' => '32 mm heavy brass waste coupling with popup plug',
                        'price' => 450.00,
                        'sort_order' => 3,
                    ],
                    [
                        'area' => 'Basin Area',
                        'cat_no' => 'F8060404AB',
                        'name' => 'Bottle Trap 175 mm',
                        'description' => 'Chrome plated brass bottle trap with 175 mm pipe',
                        'price' => 980.00,
                        'sort_order' => 4,
                    ],
                    [
                        'area' => 'Basin Area',
                        'cat_no' => 'F8040204CH',
                        'name' => 'Angle Cock with Wall Flange',
                        'description' => 'Quarter turn ceramic disc angle stop cock',
                        'price' => 620.00,
                        'sort_order' => 5,
                    ],

                    // WC Area
                    [
                        'area' => 'WC Area',
                        'cat_no' => 'S1043101',
                        'name' => 'Cavall Wall Hung EWC',
                        'description' => 'With slim soft close hydraulic seat cover',
                        'price' => 6800.00,
                        'sort_order' => 1,
                    ],
                    [
                        'area' => 'WC Area',
                        'cat_no' => 'F8010101',
                        'name' => 'Flush Valve Concealed Push Type',
                        'description' => 'Single flush 40 mm (1.5") light weight brass body',
                        'price' => 1850.00,
                        'sort_order' => 2,
                    ],
                    [
                        'area' => 'WC Area',
                        'cat_no' => 'F8030104AB',
                        'name' => 'Health Faucet with Silicone Nozzle',
                        'description' => 'High water pressure resistant with 1m SS hose pipe & hook',
                        'price' => 890.00,
                        'sort_order' => 3,
                    ],
                    [
                        'area' => 'WC Area',
                        'cat_no' => 'F1015163',
                        'name' => 'Victor - 2-Way Bib Cock',
                        'description' => 'With single knob control and wall flange',
                        'price' => 1350.00,
                        'sort_order' => 4,
                    ],

                    // Shower Area
                    [
                        'area' => 'Shower Area',
                        'cat_no' => 'F7010204AB',
                        'name' => 'Overhead Rain Shower 150 mm (6")',
                        'description' => 'With 240 mm (9.5") long heavy shower arm and wall flange',
                        'price' => 1650.00,
                        'sort_order' => 1,
                    ],
                    [
                        'area' => 'Shower Area',
                        'cat_no' => 'F1015401',
                        'name' => 'Victor - Wall Mixer with Bend Pipe',
                        'description' => 'Wall mounted mixer with provision for overhead shower',
                        'price' => 3800.00,
                        'sort_order' => 2,
                    ],
                ]
            ],

            [
                'name' => 'Configuration 2',
                'slug' => 'configuration-2',
                'brand_id' => $cera->id,
                'tagline' => 'Victor Concealed Diverter & Cluster Countertop Suite',
                'description' => 'Upgraded configuration featuring single-lever concealed diverter, Cluster Slim counter wash basin, and Clapper Pro EWC.',
                'image' => 'images/packages/cera_brochure.jpg',
                'price' => 26490.00,
                'mrp' => 33800.00,
                'sort_order' => 2,
                'is_active' => true,
                'items' => [
                    // Basin Area
                    [
                        'area' => 'Basin Area',
                        'cat_no' => 'F1015102',
                        'name' => 'Victor - Pillar Cock Extended Body',
                        'description' => '190 mm (7.5") extended height body with aerator for tabletop basins',
                        'price' => 1750.00,
                        'sort_order' => 1,
                    ],
                    [
                        'area' => 'Basin Area',
                        'cat_no' => 'S2020110',
                        'name' => 'CLUSTER SLIM Tabletop Basin',
                        'description' => '420 x 345 x 170 mm countertop design basin',
                        'price' => 3400.00,
                        'sort_order' => 2,
                    ],
                    [
                        'area' => 'Basin Area',
                        'cat_no' => 'F8050101',
                        'name' => 'Waste Coupling (Full Thread)',
                        'description' => '32 mm full thread chrome plated brass coupling',
                        'price' => 480.00,
                        'sort_order' => 3,
                    ],
                    [
                        'area' => 'Basin Area',
                        'cat_no' => 'F8060404AB',
                        'name' => 'Bottle Trap 175 mm',
                        'description' => 'Brass bottle trap with wall flange',
                        'price' => 980.00,
                        'sort_order' => 4,
                    ],
                    [
                        'area' => 'Basin Area',
                        'cat_no' => 'F8040204CH',
                        'name' => 'Angle Cock with Wall Flange',
                        'description' => 'Quarter turn ceramic disc stop valve',
                        'price' => 620.00,
                        'sort_order' => 5,
                    ],

                    // WC Area
                    [
                        'area' => 'WC Area',
                        'cat_no' => 'S1040171',
                        'name' => 'CLAPPER PRO Wall Hung EWC',
                        'description' => '515 x 365 x 380 mm rimless ceramic commode with soft close seat',
                        'price' => 8400.00,
                        'sort_order' => 1,
                    ],
                    [
                        'area' => 'WC Area',
                        'cat_no' => 'F8010204',
                        'name' => 'Flush Valve Concealed Push (Dual Flush)',
                        'description' => 'Dual flush 40 mm (1.5") water saving push type valve',
                        'price' => 2350.00,
                        'sort_order' => 2,
                    ],
                    [
                        'area' => 'WC Area',
                        'cat_no' => 'F8030124B',
                        'name' => 'Health Faucet with Silicone Nozzle',
                        'description' => 'Silicone easy-clean nozzles with 1m SS flexible hose',
                        'price' => 950.00,
                        'sort_order' => 3,
                    ],
                    [
                        'area' => 'WC Area',
                        'cat_no' => 'F1015163',
                        'name' => 'Victor - 2-Way Bib Cock',
                        'description' => 'With single knob and wall flange',
                        'price' => 1350.00,
                        'sort_order' => 4,
                    ],

                    // Shower Area
                    [
                        'area' => 'Shower Area',
                        'cat_no' => 'F7010204AB',
                        'name' => 'Overhead Rain Shower 150 mm (6")',
                        'description' => 'With 240 mm (9.5") long shower arm and wall flange',
                        'price' => 1650.00,
                        'sort_order' => 1,
                    ],
                    [
                        'area' => 'Shower Area',
                        'cat_no' => 'F1015351',
                        'name' => 'Victor - High Flow Concealed Diverter (Exposed Part)',
                        'description' => 'Single lever concealed diverter exposed trim set with baton & sleeve',
                        'price' => 2450.00,
                        'sort_order' => 2,
                    ],
                    [
                        'area' => 'Shower Area',
                        'cat_no' => 'F4030101',
                        'name' => 'Concealed Diverter Part 40 mm',
                        'description' => 'Concealed body internal cartridge unit',
                        'price' => 2650.00,
                        'sort_order' => 3,
                    ],
                    [
                        'area' => 'Shower Area',
                        'cat_no' => 'F1015661',
                        'name' => 'Victor - Bath Tub Spout',
                        'description' => 'Wall mounted cast brass spout with wall flange',
                        'price' => 1250.00,
                        'sort_order' => 4,
                    ],
                ]
            ],

            [
                'name' => 'Configuration 3',
                'slug' => 'configuration-3',
                'brand_id' => $cera->id,
                'tagline' => 'Curve Designer Suite with Concealed Cistern & Thin-Rim Basin',
                'description' => 'Elite bathroom suite pairing the organic Curve faucet series with Carneval rimless WC and concealed in-wall cistern.',
                'image' => 'images/packages/cera_brochure.jpg',
                'price' => 34990.00,
                'mrp' => 43500.00,
                'sort_order' => 3,
                'is_active' => true,
                'items' => [
                    // Basin Area
                    [
                        'area' => 'Basin Area',
                        'cat_no' => 'F1023102CH',
                        'name' => 'CURVE - Tall Pillar Cock 310 mm (12")',
                        'description' => 'Long extended body with aerator for vessel counter basins',
                        'price' => 2850.00,
                        'sort_order' => 1,
                    ],
                    [
                        'area' => 'Basin Area',
                        'cat_no' => 'S2020153',
                        'name' => 'Colloid Table Top Wash Basin',
                        'description' => 'Ultra sleek contemporary table top wash basin',
                        'price' => 4200.00,
                        'sort_order' => 2,
                    ],
                    [
                        'area' => 'Basin Area',
                        'cat_no' => 'F8050101',
                        'name' => 'Waste Coupling (Full Thread)',
                        'description' => '32 mm brass coupling',
                        'price' => 480.00,
                        'sort_order' => 3,
                    ],
                    [
                        'area' => 'Basin Area',
                        'cat_no' => 'F8060406CH',
                        'name' => 'CURVE - Bottle Trap 300 mm',
                        'description' => 'Extended 300 mm bottle trap in polished chrome',
                        'price' => 1350.00,
                        'sort_order' => 4,
                    ],
                    [
                        'area' => 'Basin Area',
                        'cat_no' => 'F1023101CH',
                        'name' => 'CURVE - Angle Cock with Wall Flange',
                        'description' => 'Curved styling quarter turn angle valve',
                        'price' => 890.00,
                        'sort_order' => 5,
                    ],

                    // WC Area
                    [
                        'area' => 'WC Area',
                        'cat_no' => 'S1049485N',
                        'name' => 'CARNEVAL RIMLESS Wall Hung EWC',
                        'description' => '510 x 365 x 380 mm with slim soft close seat cover',
                        'price' => 9600.00,
                        'sort_order' => 1,
                    ],
                    [
                        'area' => 'WC Area',
                        'cat_no' => 'B1010101',
                        'name' => 'Concealed Cistern Body',
                        'description' => 'In-wall slim cistern without frame and knob',
                        'price' => 3950.00,
                        'sort_order' => 2,
                    ],
                    [
                        'area' => 'WC Area',
                        'cat_no' => 'B1210105P',
                        'name' => 'H-Type Push Panel Plate',
                        'description' => 'Chevron dual flush actuator panel in chrome',
                        'price' => 1450.00,
                        'sort_order' => 3,
                    ],
                    [
                        'area' => 'WC Area',
                        'cat_no' => 'F8030105AB',
                        'name' => 'Health Faucet ABS Body',
                        'description' => 'With 1 meter SS braided connection pipe & holder',
                        'price' => 780.00,
                        'sort_order' => 4,
                    ],
                    [
                        'area' => 'WC Area',
                        'cat_no' => 'F1023101CH',
                        'name' => 'CURVE - Angle Cock with Wall Flange',
                        'description' => 'For cistern shut-off connection',
                        'price' => 890.00,
                        'sort_order' => 5,
                    ],

                    // Shower Area
                    [
                        'area' => 'Shower Area',
                        'cat_no' => 'F7010204AB',
                        'name' => 'Overhead Rain Shower 150 mm (6")',
                        'description' => 'With 240 mm (9.5") long shower arm',
                        'price' => 1650.00,
                        'sort_order' => 1,
                    ],
                    [
                        'area' => 'Shower Area',
                        'cat_no' => 'F1023351',
                        'name' => 'Curve - High Flow Concealed Diverter (Exposed Part)',
                        'description' => 'Single lever concealed diverter trim with baton & sleeve',
                        'price' => 2950.00,
                        'sort_order' => 2,
                    ],
                    [
                        'area' => 'Shower Area',
                        'cat_no' => 'F4030101',
                        'name' => 'Concealed Part 40 mm',
                        'description' => 'High flow 40 mm internal diverter body',
                        'price' => 2650.00,
                        'sort_order' => 3,
                    ],
                    [
                        'area' => 'Shower Area',
                        'cat_no' => 'F1023661',
                        'name' => 'Curve - Bath Tub Spout with Wall Flange',
                        'description' => 'Aerated wall spout in matching Curve form',
                        'price' => 1550.00,
                        'sort_order' => 4,
                    ],
                ]
            ],

            [
                'name' => 'Configuration 4',
                'slug' => 'configuration-4',
                'brand_id' => $cera->id,
                'tagline' => 'Cherva One-Piece EWC & Cherope Brassware Suite',
                'description' => 'Floor mounted one-piece EWC combo with extended body pillar tap and wall mixer rain shower set.',
                'image' => 'images/packages/cera_brochure.jpg',
                'price' => 22990.00,
                'mrp' => 29500.00,
                'sort_order' => 4,
                'is_active' => true,
                'items' => [
                    // Basin Area
                    [
                        'area' => 'Basin Area',
                        'cat_no' => 'F1010102',
                        'name' => 'Cherope Pillar Cock Extended Body',
                        'description' => 'Tall body chrome pillar tap with aerator',
                        'price' => 1650.00,
                        'sort_order' => 1,
                    ],
                    [
                        'area' => 'Basin Area',
                        'cat_no' => 'S1040166',
                        'name' => 'CLAIRDEL - Wall Hung Basin',
                        'description' => '405 x 325 x 145 mm vitreous china basin',
                        'price' => 2200.00,
                        'sort_order' => 2,
                    ],
                    [
                        'area' => 'Basin Area',
                        'cat_no' => 'F8050101',
                        'name' => 'Waste Coupling 32 mm',
                        'description' => 'Half thread chrome brass coupling',
                        'price' => 450.00,
                        'sort_order' => 3,
                    ],
                    [
                        'area' => 'Basin Area',
                        'cat_no' => 'F8060404AB',
                        'name' => 'Bottle Trap 175 mm',
                        'description' => 'Chrome plated bottle trap',
                        'price' => 980.00,
                        'sort_order' => 4,
                    ],
                    [
                        'area' => 'Basin Area',
                        'cat_no' => 'F8040204CH',
                        'name' => 'Angle Cock with Wall Flange',
                        'description' => 'Ceramic disc angle valve',
                        'price' => 620.00,
                        'sort_order' => 5,
                    ],

                    // WC Area
                    [
                        'area' => 'WC Area',
                        'cat_no' => 'S1013142',
                        'name' => 'Cherva One Piece EWC',
                        'description' => 'One piece toilet with slim seat cover, S-Trap 220 mm',
                        'price' => 9200.00,
                        'sort_order' => 1,
                    ],
                    [
                        'area' => 'WC Area',
                        'cat_no' => 'F8030104AB',
                        'name' => 'Health Faucet with Silicone Nozzle',
                        'description' => 'High pressure resistant with 1m SS hose pipe',
                        'price' => 890.00,
                        'sort_order' => 2,
                    ],
                    [
                        'area' => 'WC Area',
                        'cat_no' => 'F1015163',
                        'name' => 'Victor - 2-Way Angle Bib Cock',
                        'description' => 'Dual outlet with single knob control',
                        'price' => 1350.00,
                        'sort_order' => 3,
                    ],

                    // Shower Area
                    [
                        'area' => 'Shower Area',
                        'cat_no' => 'F7010204AB',
                        'name' => 'Overhead Rain Shower 150 mm (6")',
                        'description' => 'With 240 mm (9.5") long shower arm',
                        'price' => 1650.00,
                        'sort_order' => 1,
                    ],
                    [
                        'area' => 'Shower Area',
                        'cat_no' => 'F1015401',
                        'name' => 'Victor - Wall Mixer with Bend Pipe',
                        'description' => 'Wall mixer with provision for overhead shower',
                        'price' => 3800.00,
                        'sort_order' => 2,
                    ],
                ]
            ],
        ];

        foreach ($packagesData as $pkgInfo) {
            $items = $pkgInfo['items'];
            unset($pkgInfo['items']);

            $package = Package::updateOrCreate(
                ['slug' => $pkgInfo['slug']],
                $pkgInfo
            );

            // Clear old items to re-seed cleanly
            $package->items()->delete();

            foreach ($items as $itemData) {
                $itemData['package_id'] = $package->id;
                PackageItem::create($itemData);
            }
        }
    }
}

