<?php

namespace App\Http\Controllers\admin;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\DefectSectionImage;
use App\Models\DefectSection;
use Illuminate\Http\Request;

class DefectSectionImageControlle extends Controller
{
    public function store(Request $request, DefectSection $section)
{
    $request->validate([
        'image'            => 'required|image|max:2048',
        'description'      => 'required|string|max:255',
        'deduction_amount' => 'nullable|numeric|min:0',
    ]);
 
    $path = $request->file('image')->store('defect-sections', 'public');
    $section->images()->create([
        'image'            => $path,
        'description'      => $request->description,
        'deduction_amount' => $request->deduction_amount ?? 0,
    ]);
 
    return back()->with('success', 'Image added successfully.');
}
 
public function update(Request $request, DefectSectionImage $image)
{
    $request->validate([
        'image'            => 'nullable|image|max:2048',
        'description'      => 'required|string|max:255',
        'deduction_amount' => 'nullable|numeric|min:0',
    ]);
 
    $data = [
        'description'      => $request->description,
        'deduction_amount' => $request->deduction_amount ?? 0,
    ];

    if ($request->hasFile('image')) {
        Storage::disk('public')->delete($image->image);
        $data['image'] = $request->file('image')->store('defect-sections', 'public');
    }
 
    $image->update($data);
 
    return back()->with('success', 'Image updated successfully.');
}
 
public function destroy(DefectSectionImage $image)
{
    Storage::disk('public')->delete($image->image);
    $image->delete();
 
    return back()->with('success', 'Image deleted successfully.');
}
}
