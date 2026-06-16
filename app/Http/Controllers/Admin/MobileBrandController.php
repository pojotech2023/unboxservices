<?php

namespace App\Http\Controllers\Admin;  // ✅ Admin add பண்ணுங்க
use App\Http\Controllers\Controller;
use App\Models\MobileBrand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MobileBrandController extends Controller
{
    public function index()
    {
        $brands = MobileBrand::all();
        return view('admin.mobile.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.mobile.brands.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'logo'  => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = ['name' => $request->name];

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('brands/logos', 'public');
        }

        MobileBrand::create($data);

        return redirect()->route('brands.index')->with('success', 'Brand added successfully!');
    }

    public function edit(MobileBrand $brand)
    {
        return view('admin.mobile.brands.edit', compact('brand'));
    }

    public function update(Request $request, MobileBrand $brand)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'logo'  => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = ['name' => $request->name];

        if ($request->hasFile('logo')) {
            // Delete old logo
            if ($brand->logo) {
                Storage::disk('public')->delete($brand->logo);
            }
            $data['logo'] = $request->file('logo')->store('brands/logos', 'public');
        }

        $brand->update($data);

        return redirect()->route('brands.index')->with('success', 'Brand updated successfully!');
    }

    public function destroy(MobileBrand $brand)
    {
        if ($brand->logo) {
            Storage::disk('public')->delete($brand->logo);
        }
        $brand->delete();

        return redirect()->route('brands.index')->with('success', 'Brand deleted successfully!');
    }

    // View all models of a brand
    public function viewModels(MobileBrand $brand)
    {
        $models = $brand->models()->with('evaluationPricing')->get();
        return view('admin.mobile.models.index', compact('brand', 'models'));
    }
}
