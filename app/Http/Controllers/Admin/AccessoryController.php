<?php
// app/Http/Controllers/Admin/AccessoryController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VariantAccessory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AccessoryController extends Controller
{
    public function index()
    {
        $accessories = VariantAccessory::orderBy('sort_order')->get();
        return view('admin.accessories.index', compact('accessories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'items'                    => 'required|array|min:1',
            'items.*.description'      => 'required|string|max:255',
            'items.*.small_description'=> 'nullable|string|max:255',
            'items.*.image'            => 'required|image|max:2048',
        ]);

        foreach ($request->items as $item) {
            $path = $item['image']->store('accessories', 'public');
            VariantAccessory::create([
                'description'       => $item['description'],
                'small_description' => $item['small_description'] ?? null,
                'image'             => $path,
                'sort_order'        => VariantAccessory::max('sort_order') + 1,
            ]);
        }

        return back()->with('success', count($request->items) . ' accessory item(s) added successfully.');
    }

    public function update(Request $request, VariantAccessory $accessory)
    {
        $request->validate([
            'description'       => 'required|string|max:255',
            'small_description' => 'nullable|string|max:255',
            'image'             => 'nullable|image|max:2048',
        ]);

        $data = [
            'description'       => $request->description,
            'small_description' => $request->small_description,
        ];

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($accessory->image);
            $data['image'] = $request->file('image')->store('accessories', 'public');
        }

        $accessory->update($data);

        return back()->with('success', 'Accessory updated successfully.');
    }

    public function destroy(VariantAccessory $accessory)
    {
        Storage::disk('public')->delete($accessory->image);
        $accessory->delete();

        return back()->with('success', 'Accessory deleted successfully.');
    }
}
