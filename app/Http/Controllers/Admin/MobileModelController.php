<?php

namespace App\Http\Controllers\Admin;  // ✅ Admin add பண்ணுங்க
use App\Http\Controllers\Controller;
use App\Models\MobileBrand;
use App\Models\MobileModel;
use App\Models\MobileModelEvaluationPricing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MobileModelController extends Controller
{
    public function create(MobileBrand $brand)
    {
        return view('admin.mobile.models.create', compact('brand'));
    }

    public function store(Request $request, MobileBrand $brand)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'mobile_brand_id' => $brand->id,
            'name'            => $request->name,
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('models/images', 'public');
        }

        MobileModel::create($data);

        return redirect()->route('brands.models', $brand->id)->with('success', 'Model added successfully!');
    }

    public function edit(MobileBrand $brand, MobileModel $model)
    {
        return view('admin.mobile.models.edit', compact('brand', 'model'));
    }

    public function update(Request $request, MobileBrand $brand, MobileModel $model)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = ['name' => $request->name];

        if ($request->hasFile('image')) {
            if ($model->image) {
                Storage::disk('public')->delete($model->image);
            }
            $data['image'] = $request->file('image')->store('models/images', 'public');
        }

        $model->update($data);

        return redirect()->route('brands.models', $brand->id)->with('success', 'Model updated successfully!');
    }

    public function destroy(MobileBrand $brand, MobileModel $model)
    {
        if ($model->image) {
            Storage::disk('public')->delete($model->image);
        }
        $model->delete();

        return redirect()->route('brands.models', $brand->id)->with('success', 'Model deleted successfully!');
    }

    // View all variants of a model
    public function viewVariants(MobileBrand $brand, MobileModel $model)
    {
        $variants = $model->variants()->get();
        return view('admin.mobile.variants.index', compact('brand', 'model', 'variants'));
    }

    public function storeEvaluationPricing(Request $request, MobileBrand $brand, MobileModel $model)
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
        ['mobile_model_id' => $model->id],  // match condition
        $validated                           // values to set
    );

    $message = $exists ? 'Evaluation pricing updated successfully.' : 'Evaluation pricing added successfully.';

    return redirect()->route('brands.models', $brand->id)->with('success', $message);
}
}
