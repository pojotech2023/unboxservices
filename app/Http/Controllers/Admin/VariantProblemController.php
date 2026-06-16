<?php

namespace App\Http\Controllers\admin;
use App\Models\VariantProblem;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class VariantProblemController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'problems'              => 'required|array|min:1',
        'problems.*.image'      => 'required|image|max:2048',
        'problems.*.description'=> 'required|string|max:255',
    ]);
 
    // Get variant_id from session or pass as hidden input
    $variantId = session('current_variant_id'); // or $request->variant_id
 
    foreach ($request->problems as $p) {
        $path = $p['image']->store('variant-problems', 'public');
        VariantProblem::create([
            'mobile_variant_id'  => $variantId,
            'image'       => $path,
            'description' => $p['description'],
        ]);
    }
 
    return back()->with('success', 'Problems saved successfully.');
}
 
public function update(Request $request, VariantProblem $problem)
{
    $request->validate([
        'image'       => 'nullable|image|max:2048',
        'description' => 'required|string|max:255',
    ]);
 
    $data = ['description' => $request->description];
 
    if ($request->hasFile('image')) {
        Storage::disk('public')->delete($problem->image);
        $data['image'] = $request->file('image')->store('variant-problems', 'public');
    }
 
    $problem->update($data);
    return back()->with('success', 'Problem updated successfully.');
}
 
public function destroy(VariantProblem $problem)
{
    Storage::disk('public')->delete($problem->image);
    $problem->delete();
    return back()->with('success', 'Problem deleted successfully.');
}
}
