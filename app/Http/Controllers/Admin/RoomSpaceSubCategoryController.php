<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\RoomSpaceSubCategoryRequest;
use App\Models\RoomSpaceSubCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Illuminate\View\View;

class RoomSpaceSubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $subCategories = RoomSpaceSubCategory::orderBy('created_at', 'desc')->paginate(12);
        return view('admin.room_space_sub_categories.index', compact('subCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.room_space_sub_categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoomSpaceSubCategoryRequest $request): RedirectResponse
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('sub_category_images', 'public');
            $data['image_path'] = $path;
        }
        $data['slug'] = Str::slug($data['name']);
        RoomSpaceSubCategory::create($data);
        return redirect()->route('admin.room-space-sub-categories.index')
            ->with('success', 'Sub‑category created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RoomSpaceSubCategory $roomSpaceSubCategory): View
    {
        return view('admin.room_space_sub_categories.edit', compact('roomSpaceSubCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoomSpaceSubCategoryRequest $request, RoomSpaceSubCategory $roomSpaceSubCategory): RedirectResponse
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($roomSpaceSubCategory->image_path && \Storage::disk('public')->exists($roomSpaceSubCategory->image_path)) {
                \Storage::disk('public')->delete($roomSpaceSubCategory->image_path);
            }
            $path = $request->file('image')->store('sub_category_images', 'public');
            $data['image_path'] = $path;
        }
        $data['slug'] = Str::slug($data['name']);
        $roomSpaceSubCategory->update($data);
        return redirect()->route('admin.room-space-sub-categories.index')
            ->with('success', 'Sub‑category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RoomSpaceSubCategory $roomSpaceSubCategory): RedirectResponse
    {
        if ($roomSpaceSubCategory->image_path && \Storage::disk('public')->exists($roomSpaceSubCategory->image_path)) {
            \Storage::disk('public')->delete($roomSpaceSubCategory->image_path);
        }
        $roomSpaceSubCategory->delete();
        return redirect()->route('admin.room-space-sub-categories.index')
            ->with('success', 'Sub‑category deleted successfully.');
    }
}

