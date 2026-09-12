<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class InspirationController extends Controller
{
    public function index(Request $request)
    {
        $activeFilter = $request->query('filter', 'all');

        $projects = [
            [
                'id' => 1,
                'title' => 'The Indiranagar Sky Villa Master Ensuite',
                'location' => 'Indiranagar, Bangalore',
                'type' => 'Luxury Villa Sanctuary',
                'space' => 'bathroom',
                'space_name' => 'Bathroom & Wellness',
                'image' => 'images/gallery/project_bathroom.jpg',
                'description' => 'A master ensuite bathroom finished in bookmatched Statuario Italian porcelain surfaces, brushed gold thermostatic fixtures, and a sculptural matte black freestanding bathtub.',
                'materials' => [
                    'Bookmatch Statuario Glazed Vitrified Tiles (600x1200mm)',
                    'Sculptural Matte Black Freestanding Bathtub',
                    'Single Lever Tall Body Basin Mixer in Brushed Brass',
                    'Floating Walnut Double Vanity with LED Mirrors',
                    'Concealed Rimless Wall Hung WC with Soft-Close'
                ],
                'products_url' => '/products?room=bathroom&category=sanitary-ware'
            ],
            [
                'id' => 2,
                'title' => 'Monochrome Penthouse Living Room',
                'location' => 'Koramangala, Bangalore',
                'type' => 'Modern Penthouse',
                'space' => 'living-room',
                'space_name' => 'Living Spaces',
                'image' => 'images/gallery/project_living.jpg',
                'description' => 'Seamless double-height living room featuring high-gloss 800x1600mm Statuario porcelain tiles with subtle golden-grey veining, reflecting natural daylight from panoramic windows.',
                'materials' => [
                    '800x1600mm Large Format Polished Porcelain Slabs',
                    'Soft Gold Vein Statuario Vitrified Flooring',
                    'Minimalist Acoustic Wall Cladding Paneling',
                    'Flush Skirting Profiles'
                ],
                'products_url' => '/products?room=living-room&category=tiles'
            ],
            [
                'id' => 3,
                'title' => 'Monolithic Marble Chef Kitchen & Island',
                'location' => 'Lavelle Road, Bangalore',
                'type' => 'Designer Residence',
                'space' => 'kitchen',
                'space_name' => 'Kitchen',
                'image' => 'images/gallery/project_kitchen.jpg',
                'description' => 'A statement black and gold marble waterfall island matched with matte charcoal handleless cabinetry, fluted ceramic backsplash tiles, and a high-neck brass pull-down faucet.',
                'materials' => [
                    'Black & Gold Marble Waterfall Countertop Slabs',
                    'Fluted Matte Charcoal Ceramic Backsplash Tiles',
                    'Single Lever Pull-Down Brass Kitchen Mixer',
                    'Concealed Under-Cabinet LED Strip Profile'
                ],
                'products_url' => '/products?room=kitchen'
            ],
            [
                'id' => 4,
                'title' => 'Al Fresco Infinity Pool Deck & Patio',
                'location' => 'Sadashivnagar, Bangalore',
                'type' => 'Terrace Garden & Pool',
                'space' => 'outdoor',
                'space_name' => 'Outdoor & Deck',
                'image' => 'images/gallery/project_outdoor.jpg',
                'description' => 'Heavy-duty 16mm textured anti-skid porcelain pavers engineered for all-weather outdoor environments, swimming pool surrounds, and landscaped terrace lounges.',
                'materials' => [
                    'Anti-Skid Punch Finish 400x400mm Outdoor Pavers',
                    'Weatherproof Tile Grout & Sub-Deck Spacers',
                    'Concealed Slit Floor Drain Channels',
                    'Teak Finished Exterior Pool Lounge Fixtures'
                ],
                'products_url' => '/products?category=tiles&subcategory=outdoor-tiles'
            ],
            [
                'id' => 5,
                'title' => 'Japandi Spa Bathroom & Wellness Retreat',
                'location' => 'Whitefield, Bangalore',
                'type' => 'Private Villa',
                'space' => 'bathroom',
                'space_name' => 'Bathroom & Wellness',
                'image' => 'images/gallery/project_spa.jpg',
                'description' => 'Textured grey slate vitrified wall tiles, a walk-in shower with fluted glass screen, matte black thermostatic overhead rain shower, and a built-in recessed warm LED niche.',
                'materials' => [
                    'Textured Natural Slate Vitrified Wall & Floor Tiles',
                    'Fluted Glass Frameless Shower Screen Partition',
                    'Matte Black Concealed Thermostatic Shower Diverter',
                    'Floating Walnut Vanity with Table Top Basin',
                    'LED Anti-Fog Backlit Circular Smart Mirror'
                ],
                'products_url' => '/products?room=bathroom&category=showers'
            ],
            [
                'id' => 6,
                'title' => 'Boutique Architectural Studio Reception & Gallery',
                'location' => 'MG Road, Bangalore',
                'type' => 'Commercial Studio',
                'space' => 'commercial',
                'space_name' => 'Commercial & Studio',
                'image' => 'images/gallery/project_commercial.jpg',
                'description' => 'High-traffic commercial vitrified tile installation with dramatic natural stone veining, custom brushed copper reception desk, and curated material display walls.',
                'materials' => [
                    'High Gloss Mirror-Finish Porcelain Floor Slabs',
                    'Curated Wall Display Racks & Tile Swatches',
                    'Architectural Skirting & Brushed Metal Trims'
                ],
                'products_url' => '/products?category=tiles'
            ],
        ];

        // Filter projects if requested
        if ($activeFilter !== 'all') {
            $filteredProjects = array_values(array_filter($projects, function ($p) use ($activeFilter) {
                return $p['space'] === $activeFilter;
            }));
        } else {
            $filteredProjects = $projects;
        }

        $rooms = Room::all();

        return view('inspiration.index', [
            'projects' => $filteredProjects,
            'allProjects' => $projects,
            'activeFilter' => $activeFilter,
            'rooms' => $rooms,
        ]);
    }
}
