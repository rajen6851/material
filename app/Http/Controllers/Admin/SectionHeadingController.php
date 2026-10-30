<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SectionHeading;
use Illuminate\Http\Request;

class SectionHeadingController extends Controller
{
    public function index()
    {
        $headings = SectionHeading::latest()->get();

        return view('admin.section-headings.index', compact('headings'));
    }

    public function create()
    {
        return view('admin.section-headings.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'section_key' => 'required|string|max:100|unique:section_headings,section_key',
            'heading' => 'required|string|max:255',
            'subheading' => 'nullable|string|max:255',
        ]);

        SectionHeading::create([
            'section_key' => $request->section_key,
            'heading' => $request->heading,
            'subheading' => $request->subheading,
        ]);

        return redirect()
            ->route('admin.section-headings.index')
            ->with('success', 'Section heading created successfully.');
    }

    public function edit(SectionHeading $sectionHeading)
    {
        return view(
            'admin.section-headings.edit',
            compact('sectionHeading')
        );
    }

    public function update(Request $request, SectionHeading $sectionHeading)
    {
        $request->validate([
            'section_key' => 'required|string|max:100|unique:section_headings,section_key,' . $sectionHeading->id,
            'heading' => 'required|string|max:255',
            'subheading' => 'nullable|string|max:255',
        ]);

        $sectionHeading->update([
            'section_key' => $request->section_key,
            'heading' => $request->heading,
            'subheading' => $request->subheading,
        ]);

        return redirect()
            ->route('admin.section-headings.index')
            ->with('success', 'Section heading updated successfully.');
    }

    public function destroy(SectionHeading $sectionHeading)
    {
        $sectionHeading->delete();

        return redirect()
            ->route('admin.section-headings.index')
            ->with('success', 'Section heading deleted successfully.');
    }
}