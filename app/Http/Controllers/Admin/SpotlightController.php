<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Spotlight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SpotlightController extends Controller
{
    /**
     * Display all spotlights
     */
    public function index()
    {
        $spotlights = Spotlight::orderBy('sort_order')
            ->orderByDesc('id')
            ->get();

        return view('admin.spotlights.index', compact('spotlights'));
    }

    /**
     * Create page
     */
    public function create()
    {
        return view('admin.spotlights.create');
    }

    /**
     * Store
     */
    public function store(Request $request)
    {
        $request->validate([
            'label' => 'nullable|string|max:255',

            'title' => 'required|string|max:255',

            'description' => 'nullable|string',

            'category_slug' => 'nullable|string|max:255',

            'button_text' => 'required|string|max:100',

            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',

            'sort_order' => 'nullable|integer',

            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->only([
            'label',
            'title',
            'description',
            'category_slug',
            'button_text',
            'sort_order',
        ]);

        $data['is_active'] = $request->boolean('is_active');

        /*
        |--------------------------------------------------------------------------
        | Upload image
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('image')) {

            $path = $request->file('image')->store(
                'spotlights',
                'public'
            );

            $data['image'] = $path;
        }

        Spotlight::create($data);

        return redirect()
            ->route('admin.spotlights.index')
            ->with('success', 'Spotlight created successfully.');
    }

    /**
     * Edit
     */
    public function edit(Spotlight $spotlight)
    {
        return view(
            'admin.spotlights.edit',
            compact('spotlight')
        );
    }

    /**
     * Update
     */
    public function update(
        Request $request,
        Spotlight $spotlight
    ) {

        $request->validate([
            'label' => 'nullable|string|max:255',

            'title' => 'required|string|max:255',

            'description' => 'nullable|string',

            'category_slug' => 'nullable|string|max:255',

            'button_text' => 'required|string|max:100',

            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',

            'sort_order' => 'nullable|integer',

            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->only([
            'label',
            'title',
            'description',
            'category_slug',
            'button_text',
            'sort_order',
        ]);

        $data['is_active'] = $request->boolean('is_active');

        /*
        |--------------------------------------------------------------------------
        | Replace image
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('image')) {

            if (
                $spotlight->image &&
                Storage::disk('public')->exists($spotlight->image)
            ) {
                Storage::disk('public')->delete(
                    $spotlight->image
                );
            }

            $path = $request->file('image')->store(
                'spotlights',
                'public'
            );

            $data['image'] = $path;
        }

        $spotlight->update($data);

        return redirect()
            ->route('admin.spotlights.index')
            ->with('success', 'Spotlight updated successfully.');
    }

    /**
     * Delete
     */
    public function destroy(Spotlight $spotlight)
    {
        if (
            $spotlight->image &&
            Storage::disk('public')->exists($spotlight->image)
        ) {
            Storage::disk('public')->delete(
                $spotlight->image
            );
        }

        $spotlight->delete();

        return back()->with(
            'success',
            'Spotlight deleted successfully.'
        );
    }
}