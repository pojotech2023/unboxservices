<?php

namespace App\Http\Controllers\admin;
use App\Models\VariantDefect;
use App\Models\DefectSection;
use App\Models\DefectSectionImage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class DefectSectionController extends Controller
{
    public function store(Request $request, VariantDefect $defect)
{
    $request->validate([
        'title'               => 'required|string|max:255',
        'description'         => 'nullable|string|max:500',
        'images'              => 'required|array|min:1',
        'images.*.image'      => 'required|image|max:2048',
        'images.*.description'=> 'required|string|max:255',
    ]);
 
    $section = $defect->sections()->create([
        'title'       => $request->title,
        'description' => $request->description,
    ]);
 
    foreach ($request->images as $imgData) {
        $path = $imgData['image']->store('defect-sections', 'public');
        $section->images()->create([
            'image'       => $path,
            'description' => $imgData['description'],
        ]);
    }
 
    return back()->with('success', 'Section added successfully.');
}
 
public function update(Request $request, DefectSection $section)
{
    $request->validate([
        'title'       => 'required|string|max:255',
        'description' => 'nullable|string|max:500',
    ]);
 
    $section->update($request->only('title', 'description'));
 
    return back()->with('success', 'Section updated successfully.');
}
 
public function destroy(DefectSection $section)
{
    // Delete all associated images from storage
    foreach ($section->images as $img) {
        Storage::disk('public')->delete($img->image);
    }
    $section->delete();
 
    return back()->with('success', 'Section deleted successfully.');
}
}
