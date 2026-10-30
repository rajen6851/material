<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Brand;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    /**
     * Display public listing of bathroom packages.
     */
    public function index(Request $request)
    {
        $brandSlug = $request->get('brand');

        $query = Package::with(['brand', 'items.product'])
            ->where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'asc');

        if ($brandSlug) {
            $brand = Brand::where('slug', $brandSlug)->first();
            if ($brand) {
                $query->where('brand_id', $brand->id);
            }
        }

        $packages = $query->get();

        // Get brands that have active packages
        $brands = Brand::whereHas('packages', function ($q) {
            $q->where('is_active', true);
        })->get();

        // If no packages are assigned to brand specifically, get all brands for filter
        if ($brands->isEmpty()) {
            $brands = Brand::orderBy('name')->get();
        }

        return view('packages.index', compact('packages', 'brands', 'brandSlug'));
    }

    /**
     * Display single package details.
     */
    public function show($slug)
    {
        $package = Package::with(['brand', 'items.product'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $relatedPackages = Package::where('id', '!=', $package->id)
            ->where('is_active', true)
            ->limit(3)
            ->get();

        return view('packages.show', compact('package', 'relatedPackages'));
    }
}

