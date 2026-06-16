<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LaptopBrand;
use App\Models\LaptopModel;
use App\Models\LaptopVariant;
use App\Models\LaptopModelEvaluationPricing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LaptopModelController extends Controller
{
    public function create(LaptopBrand $laptopBrand)
    {
        return view('admin.laptop.models.create', compact('laptopBrand'));
    }

    public function store(Request $request, LaptopBrand $laptopBrand)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'laptop_brand_id' => $laptopBrand->id,
            'name'  => $request->name,
            'price' => $request->price,
        ];
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('laptop/models', 'public');
        }

        LaptopModel::create($data);
        return redirect()->route('laptop.brands.models.index', $laptopBrand->id)
                         ->with('success', 'Model added!');
    }

    public function edit(LaptopBrand $laptopBrand, LaptopModel $laptopModel)
    {
        return view('admin.laptop.models.edit', compact('laptopBrand', 'laptopModel'));
    }

    public function update(Request $request, LaptopBrand $laptopBrand, LaptopModel $laptopModel)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = ['name' => $request->name, 'price' => $request->price];
        if ($request->hasFile('image')) {
            if ($laptopModel->image) Storage::disk('public')->delete($laptopModel->image);
            $data['image'] = $request->file('image')->store('laptop/models', 'public');
        }

        $laptopModel->update($data);
        return redirect()->route('laptop.brands.models.index', $laptopBrand->id)
                         ->with('success', 'Model updated!');
    }

    public function destroy(LaptopBrand $laptopBrand, LaptopModel $laptopModel)
    {
        if ($laptopModel->image) Storage::disk('public')->delete($laptopModel->image);
        $laptopModel->delete();
        return redirect()->route('laptop.brands.models.index', $laptopBrand->id)
                         ->with('success', 'Model deleted!');
    }

    public function viewVariants(LaptopBrand $laptopBrand, LaptopModel $laptopModel)
    {
        $variants = $laptopModel->variants()->get();
        return view('admin.laptop.variants.index', compact('laptopBrand', 'laptopModel', 'variants'));
    }
    public function evaluationPricingStore(Request $request, LaptopBrand $laptopBrand, LaptopModel $model)
    {
        $validated = $request->validate([
            'full_positive_price'       => 'required|numeric|min:0',
            'full_positive_description' => 'nullable|string|max:255',
            'full_negative_price'       => 'required|numeric|min:0',
            'full_negative_description' => 'nullable|string|max:255',
            'mixed_price'               => 'required|numeric|min:0',
            'mixed_description'         => 'nullable|string|max:255',
        ]);

        $exists = $model->evaluationPricing()->exists();

        $model->evaluationPricing()->updateOrCreate(
            [],
            $validated
        );

        $message = $exists
            ? 'Evaluation pricing updated successfully.'
            : 'Evaluation pricing added successfully.';

        return redirect()
            ->route('laptop.brands.models.index', $laptopBrand->id)
            ->with('succes', $message);
    }
}