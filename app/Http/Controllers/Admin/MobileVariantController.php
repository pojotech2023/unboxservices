<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MobileBrand;
use App\Models\MobileModel;
use App\Models\MobileVariant;
use Illuminate\Http\Request;

class MobileVariantController extends Controller
{
    /**
     * Variants list page
     * View: resources/views/admin/mobile/variants/index.blade.php
     * Route name: brands.models.variants (called from MobileModelController->viewVariants)
     */
    public function index(MobileBrand $brand, MobileModel $model)
    {
        $variants = $model->variants()
            ->withCount('questions')
            ->orderBy('id')
            ->get();

        // ✅ IMPORTANT: view name is 'admin.mobile.variants.index'
        // Make sure your file is at:
        // resources/views/admin/mobile/variants/index.blade.php
        return view('admin.mobile.variants.index', compact('brand', 'model', 'variants'));
    }

    // Add Variant Form
    public function create(MobileBrand $brand, MobileModel $model)
    {
        return view('admin.mobile.variants.create', compact('brand', 'model'));
    }

    // Store Variants
    public function store(Request $request, MobileBrand $brand, MobileModel $model)
    {
        $request->validate([
            'variants'           => 'required|array|min:1',
            'variants.*.memory'  => 'required|string|max:50',
            'variants.*.price'   => 'required|numeric|min:0',
        ]);

        foreach ($request->variants as $variantData) {
            MobileVariant::create([
                'mobile_model_id' => $model->id,
                'memory'          => $variantData['memory'],
                'price'           => $variantData['price'],
            ]);
        }

        return redirect()->route('brands.models.variants', [$brand->id, $model->id])
            ->with('success', 'Variants added successfully!');
    }

    // Edit Form
    public function edit(MobileBrand $brand, MobileModel $model, MobileVariant $variant)
    {
        return view('admin.mobile.variants.edit', compact('brand', 'model', 'variant'));
    }

    // Update
    public function update(Request $request, MobileBrand $brand, MobileModel $model, MobileVariant $variant)
    {
        $request->validate([
            'memory' => 'required|string|max:50',
            'price'  => 'required|numeric|min:0',
        ]);

        $variant->update([
            'memory' => $request->memory,
            'price'  => $request->price,
        ]);

        return redirect()->route('brands.models.variants', [$brand->id, $model->id])
            ->with('success', 'Variant updated successfully!');
    }

    // Delete
    public function destroy(MobileBrand $brand, MobileModel $model, MobileVariant $variant)
    {
        $variant->delete();

        return redirect()->route('brands.models.variants', [$brand->id, $model->id])
            ->with('success', 'Variant deleted successfully!');
    }
}