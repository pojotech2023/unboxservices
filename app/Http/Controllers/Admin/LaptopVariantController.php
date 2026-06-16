<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LaptopBrand;
use App\Models\LaptopModel;
use App\Models\LaptopVariant;
use Illuminate\Http\Request;

class LaptopVariantController extends Controller
{
    public function create(LaptopBrand $laptopBrand, LaptopModel $laptopModel)
    {
        return view('admin.laptop.variants.create', compact('laptopBrand', 'laptopModel'));
    }

    public function store(Request $request, LaptopBrand $laptopBrand, LaptopModel $laptopModel)
    {
        $request->validate([
            'storage' => 'required|string|max:100',
            'ram'     => 'required|string|max:100',
            'price'   => 'required|numeric|min:0',
        ]);

        LaptopVariant::create([
            'laptop_model_id' => $laptopModel->id,
            'storage' => $request->storage,
            'ram'     => $request->ram,
            'price'   => $request->price,
        ]);

        return redirect()->route('laptop.models.variants', [$laptopBrand->id, $laptopModel->id])
                         ->with('success', 'Variant added!');
    }

    public function edit(LaptopBrand $laptopBrand, LaptopModel $laptopModel, LaptopVariant $laptopVariant)
    {
        return view('admin.laptop.variants.edit', compact('laptopBrand', 'laptopModel', 'laptopVariant'));
    }

    public function update(Request $request, LaptopBrand $laptopBrand, LaptopModel $laptopModel, LaptopVariant $laptopVariant)
    {
        $request->validate([
            'storage' => 'required|string|max:100',
            'ram'     => 'required|string|max:100',
            'price'   => 'required|numeric|min:0',
        ]);

        $laptopVariant->update($request->only('storage', 'ram', 'price'));
        return redirect()->route('laptop.models.variants', [$laptopBrand->id, $laptopModel->id])
                         ->with('success', 'Variant updated!');
    }

    public function destroy(LaptopBrand $laptopBrand, LaptopModel $laptopModel, LaptopVariant $laptopVariant)
    {
        $laptopVariant->delete();
        return redirect()->route('laptop.models.variants', [$laptopBrand->id, $laptopModel->id])
                         ->with('success', 'Variant deleted!');
    }
}
