<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RoomController extends Controller
{
    public function show(Room $room)
    {
        // 1. Fetch all products belonging to this room with their Category, Brand, Images
        $roomProducts = Product::with(['category', 'brand', 'images'])
            ->where('room_id', $room->id)
            ->get();

        $totalProductsCount = $roomProducts->count();

        // 2. Fetch all categories with their subcategories
        $allCategories = Category::with('subCategories')->get();
        $groupedByCategory = collect();
        $allSubCategoriesList = collect();

        foreach ($allCategories as $cat) {
            $catRoomProducts = $roomProducts->where('category_id', $cat->id);
            $subCatsList = [];
            $addedSlugs = [];

            // A. Include all subcategories from sub_categories table
            foreach ($cat->subCategories as $sc) {
                $matching = $catRoomProducts->filter(function ($p) use ($sc) {
                    return Str::slug($p->sub_category) === $sc->slug
                        || stripos($p->sub_category, $sc->name) !== false
                        || stripos($sc->name, (string)$p->sub_category) !== false;
                });
                $first = $matching->first();
                $item = [
                    'name' => $sc->name,
                    'slug' => $sc->slug,
                    'category_name' => $cat->name,
                    'category_slug' => $cat->slug,
                    'count' => $matching->count(),
                    'sample_image' => $first ? $first->featured_image : ($sc->image ?: $cat->image),
                    'description' => 'Explore luxury ' . $sc->name . ' for ' . $room->name,
                    'min_price' => $matching->isNotEmpty() ? $matching->min('price') : null,
                ];
                $subCatsList[] = $item;
                $allSubCategoriesList->push($item);
                $addedSlugs[] = $sc->slug;
            }

            // B. Also include any product sub_category not in sub_categories table
            $extraSubs = $catRoomProducts->groupBy('sub_category');
            foreach ($extraSubs as $subName => $prods) {
                if ($subName) {
                    $subSlug = Str::slug($subName);
                    if (!in_array($subSlug, $addedSlugs)) {
                        $first = $prods->first();
                        $item = [
                            'name' => $subName,
                            'slug' => $subSlug,
                            'category_name' => $cat->name,
                            'category_slug' => $cat->slug,
                            'count' => $prods->count(),
                            'sample_image' => $first ? $first->featured_image : $cat->image,
                            'description' => 'Explore luxury ' . $subName . ' for ' . $room->name,
                            'min_price' => $prods->min('price'),
                        ];
                        $subCatsList[] = $item;
                        $allSubCategoriesList->push($item);
                        $addedSlugs[] = $subSlug;
                    }
                }
            }

            if (!empty($subCatsList) || $catRoomProducts->isNotEmpty()) {
                $groupedByCategory->push([
                    'category' => $cat,
                    'subcategories' => $subCatsList,
                    'count' => $catRoomProducts->count(),
                ]);
            }
        }

        $subCategories = $allSubCategoriesList;

        // Preview items for bottom spotlight
        $previewProducts = $roomProducts->take(8);

        return view('rooms.show', compact('room', 'subCategories', 'groupedByCategory', 'previewProducts', 'totalProductsCount'));
    }
}
