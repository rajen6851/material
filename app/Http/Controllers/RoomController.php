<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;

class RoomController extends Controller
{
    public function show(Room $room)
    {
        /*
        |--------------------------------------------------------------------------
        | 1. Fetch ONLY products belonging to this room
        |--------------------------------------------------------------------------
        |
        | Products and Rooms are connected through:
        |
        | product_room
        |
        | So DO NOT use:
        | where('room_id', $room->id)
        |
        |--------------------------------------------------------------------------
        */

        $roomProducts = Product::with([
                'category',
                'brand',
                'images'
            ])
            ->whereHas('rooms', function ($query) use ($room) {
                $query->where('rooms.id', $room->id);
            })
            ->get();


        $totalProductsCount = $roomProducts->count();


        /*
        |--------------------------------------------------------------------------
        | 2. Fetch categories with subcategories
        |--------------------------------------------------------------------------
        */

        $allCategories = Category::with('subCategories')->get();

        $groupedByCategory = collect();

        $allSubCategoriesList = collect();


        /*
        |--------------------------------------------------------------------------
        | 3. Build Category -> Subcategory structure
        |--------------------------------------------------------------------------
        */

        foreach ($allCategories as $cat) {

            /*
            |--------------------------------------------------------------------------
            | Products of THIS ROOM + THIS CATEGORY
            |--------------------------------------------------------------------------
            */

            $catRoomProducts = $roomProducts->where(
                'category_id',
                $cat->id
            );


            $subCatsList = [];

            $addedSlugs = [];


            /*
            |--------------------------------------------------------------------------
            | A. Subcategories from sub_categories table
            |--------------------------------------------------------------------------
            */

            foreach ($cat->subCategories as $sc) {

                $matching = $catRoomProducts->filter(
                    function ($p) use ($sc) {

                        $productSubCategory = trim(
                            (string) $p->sub_category
                        );

                        $subCategoryName = trim(
                            (string) $sc->name
                        );


                        if (
                            $productSubCategory === '' ||
                            $subCategoryName === ''
                        ) {
                            return false;
                        }


                        return
                            Str::slug($productSubCategory) === $sc->slug
                            ||
                            stripos(
                                $productSubCategory,
                                $subCategoryName
                            ) !== false
                            ||
                            stripos(
                                $subCategoryName,
                                $productSubCategory
                            ) !== false;
                    }
                );


                /*
                |--------------------------------------------------------------------------
                | Show ONLY if this subcategory has products
                | inside CURRENT ROOM
                |--------------------------------------------------------------------------
                */

                if ($matching->isNotEmpty()) {

                    $first = $matching->first();


                    /*
                    |--------------------------------------------------------------------------
                    | Image Priority
                    |
                    | 1. Subcategory image
                    | 2. Product featured image
                    | 3. Category image
                    |--------------------------------------------------------------------------
                    */

                    $sampleImage = null;


                    if (!empty($sc->image)) {

                        $sampleImage = $sc->image;

                    } elseif (
                        $first &&
                        !empty($first->featured_image)
                    ) {

                        $sampleImage = $first->featured_image;

                    } elseif (!empty($cat->image)) {

                        $sampleImage = $cat->image;
                    }


                    $item = [

                        'name' => $sc->name,

                        'slug' => $sc->slug,

                        'category_name' => $cat->name,

                        'category_slug' => $cat->slug,

                        /*
                        | IMPORTANT
                        | Count is ONLY for current room
                        */

                        'count' => $matching->count(),

                        'sample_image' => $sampleImage,

                        'description' =>
                            'Explore luxury '
                            . $sc->name
                            . ' for '
                            . $room->name,

                        'min_price' =>
                            $matching->min('price'),
                    ];


                    $subCatsList[] = $item;

                    $allSubCategoriesList->push($item);

                    $addedSlugs[] = $sc->slug;
                }
            }


            /*
            |--------------------------------------------------------------------------
            | B. Subcategories present in products
            |    but missing from sub_categories table
            |--------------------------------------------------------------------------
            */

            $extraSubs = $catRoomProducts
                ->filter(function ($product) {

                    return !empty(
                        trim((string) $product->sub_category)
                    );
                })
                ->groupBy(function ($product) {

                    return trim(
                        (string) $product->sub_category
                    );
                });


            foreach ($extraSubs as $subName => $prods) {

                if (empty(trim($subName))) {
                    continue;
                }


                $subSlug = Str::slug($subName);


                /*
                |--------------------------------------------------------------------------
                | Avoid duplicate subcategory
                |--------------------------------------------------------------------------
                */

                if (in_array($subSlug, $addedSlugs)) {
                    continue;
                }


                $first = $prods->first();


                /*
                |--------------------------------------------------------------------------
                | Image Priority
                |
                | 1. Product featured image
                | 2. Category image
                |--------------------------------------------------------------------------
                */

                $sampleImage = null;


                if (
                    $first &&
                    !empty($first->featured_image)
                ) {

                    $sampleImage = $first->featured_image;

                } elseif (!empty($cat->image)) {

                    $sampleImage = $cat->image;
                }


                $item = [

                    'name' => $subName,

                    'slug' => $subSlug,

                    'category_name' => $cat->name,

                    'category_slug' => $cat->slug,

                    /*
                    | ONLY CURRENT ROOM PRODUCTS
                    */

                    'count' => $prods->count(),

                    'sample_image' => $sampleImage,

                    'description' =>
                        'Explore luxury '
                        . $subName
                        . ' for '
                        . $room->name,

                    'min_price' =>
                        $prods->min('price'),
                ];


                $subCatsList[] = $item;

                $allSubCategoriesList->push($item);

                $addedSlugs[] = $subSlug;
            }


            /*
            |--------------------------------------------------------------------------
            | Add category ONLY when this room has products
            |--------------------------------------------------------------------------
            */

            if ($catRoomProducts->isNotEmpty()) {

                $groupedByCategory->push([

                    'category' => $cat,

                    'subcategories' => $subCatsList,

                    'count' => $catRoomProducts->count(),

                ]);
            }
        }


        /*
        |--------------------------------------------------------------------------
        | 4. All subcategories for this room
        |--------------------------------------------------------------------------
        */

        $subCategories = $allSubCategoriesList;


        /*
        |--------------------------------------------------------------------------
        | 5. Preview products
        |--------------------------------------------------------------------------
        */

        $previewProducts = $roomProducts->take(8);


        /*
        |--------------------------------------------------------------------------
        | 6. Return view
        |--------------------------------------------------------------------------
        */

        return view(
            'rooms.show',
            compact(
                'room',
                'subCategories',
                'groupedByCategory',
                'previewProducts',
                'totalProductsCount'
            )
        );
    }
}

