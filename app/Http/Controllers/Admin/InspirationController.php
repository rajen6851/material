<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inspiration;
use Illuminate\Http\Request;

class InspirationController extends Controller
{
    public function index()
    {
        $inspirations = Inspiration::latest()->get();
        return view('admin.inspirations.index', compact('inspirations'));
    }

    public function create()
    {
        return view('admin.inspirations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/gallery'), $imageName);
            $imagePath = 'images/gallery/' . $imageName;
        }

        // Split materials by new line
        $materials = $request->materials ? array_map('trim', explode("\n", $request->materials)) : [];

        Inspiration::create([
            'title' => $request->title,
            'location' => $request->location,
            'type' => $request->type,
            'space' => $request->space,
            'space_name' => $request->space_name,
            'description' => $request->description,
            'materials' => $materials,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.inspirations.index')->with('success', 'Inspiration project added.');
    }

    public function edit(Inspiration $inspiration)
    {
        return view('admin.inspirations.edit', compact('inspiration'));
    }

    public function update(Request $request, Inspiration $inspiration)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = $inspiration->image;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/gallery'), $imageName);
            $imagePath = 'images/gallery/' . $imageName;
        }

        $materials = $request->materials ? array_map('trim', explode("\n", $request->materials)) : [];

        $inspiration->update([
            'title' => $request->title,
            'location' => $request->location,
            'type' => $request->type,
            'space' => $request->space,
            'space_name' => $request->space_name,
            'description' => $request->description,
            'materials' => $materials,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.inspirations.index')->with('success', 'Inspiration project updated.');
    }

    public function destroy(Inspiration $inspiration)
    {
        $inspiration->delete();
        return redirect()->route('admin.inspirations.index')->with('success', 'Inspiration deleted.');
    }
}
