<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LaptopBrand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LaptopBrandController extends Controller
{
    public function index()
    {
        $brands = LaptopBrand::withCount('models')->get();
        return view('admin.laptop.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.laptop.brands.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = ['name' => $request->name];
        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('laptop/brands', 'public');
        }

        LaptopBrand::create($data);
        return redirect()->route('laptop.brands.index')->with('success', 'Brand added!');
    }

    public function edit(LaptopBrand $laptopBrand)
    {
        return view('admin.laptop.brands.edit', compact('laptopBrand'));
    }

    public function update(Request $request, LaptopBrand $laptopBrand)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = ['name' => $request->name];
        if ($request->hasFile('logo')) {
            if ($laptopBrand->logo) Storage::disk('public')->delete($laptopBrand->logo);
            $data['logo'] = $request->file('logo')->store('laptop/brands', 'public');
        }

        $laptopBrand->update($data);
        return redirect()->route('laptop.brands.index')->with('success', 'Brand updated!');
    }

    public function destroy(LaptopBrand $laptopBrand)
    {
        if ($laptopBrand->logo) Storage::disk('public')->delete($laptopBrand->logo);
        $laptopBrand->delete();
        return redirect()->route('laptop.brands.index')->with('success', 'Brand deleted!');
    }

    public function viewModels(LaptopBrand $laptopBrand)
    {
        $models = $laptopBrand->models()->get();
        return view('admin.laptop.models.index', compact('laptopBrand', 'models'));
    }
}