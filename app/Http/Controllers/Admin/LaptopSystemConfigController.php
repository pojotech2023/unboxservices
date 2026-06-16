<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\LaptopBrand;
use App\Models\LaptopModel;
use App\Models\LaptopSystemConfig;
use Illuminate\Http\Request;


class LaptopSystemConfigController extends Controller
{
    /**
     * List all system configs for a model
     */
    public function index(LaptopBrand $brand, LaptopModel $model)
    {
        $configs = $model->systemConfigs()
            ->ordered()
            ->get()
            ->groupBy('config_type');

        return view('admin.laptop.system-configs.index', compact('brand', 'model', 'configs'));
    }

    /**
     * Show create form
     */
    public function create(LaptopBrand $brand, LaptopModel $model)
    {
        $types = LaptopSystemConfig::TYPES;
        return view('admin.laptop.system-configs.create', compact('brand', 'model', 'types'));
    }

    /**
     * Store new config
     */
    public function store(Request $request, LaptopBrand $brand, LaptopModel $model)
    {
        $request->validate([
            'config_type' => 'required|in:processor,ram,storage',
            'value'       => 'required|string|max:100',
            'sort_order'  => 'nullable|integer|min:0',
            'is_active'   => 'nullable|boolean',
        ]);

        $model->systemConfigs()->create([
            'config_type' => $request->config_type,
            'value'       => trim($request->value),
            'sort_order'  => $request->sort_order ?? 0,
            'is_active'   => $request->boolean('is_active', true),
        ]);

        return redirect()
            ->route('laptop.models.system-configs.index', [$brand->id, $model->id])
            ->with('success', 'Config added successfully!');
    }

    /**
     * Show edit form
     */
    public function edit(LaptopBrand $brand, LaptopModel $model, LaptopSystemConfig $config)
    {
        $types = LaptopSystemConfig::TYPES;
        return view('admin.laptop.system-configs.edit', compact('brand', 'model', 'config', 'types'));
    }

    /**
     * Update config
     */
    public function update(Request $request, LaptopBrand $brand, LaptopModel $model, LaptopSystemConfig $config)
    {
        $request->validate([
            'config_type' => 'required|in:processor,ram,storage',
            'value'       => 'required|string|max:100',
            'sort_order'  => 'nullable|integer|min:0',
            'is_active'   => 'nullable|boolean',
        ]);

        $config->update([
            'config_type' => $request->config_type,
            'value'       => trim($request->value),
            'sort_order'  => $request->sort_order ?? 0,
            'is_active'   => $request->boolean('is_active', true),
        ]);

        return redirect()
            ->route('laptop.models.system-configs.index', [$brand->id, $model->id])
            ->with('success', 'Config updated successfully!');
    }

    /**
     * Delete config
     */
    public function destroy(LaptopBrand $brand, LaptopModel $model, LaptopSystemConfig $config)
    {
        $config->delete();
        return redirect()
            ->route('laptop.models.system-configs.index', [$brand->id, $model->id])
            ->with('success', 'Config deleted.');
    }

    /**
     * Toggle active status (AJAX)
     */
    public function toggleActive(LaptopBrand $brand, LaptopModel $model, LaptopSystemConfig $config)
    {
        $config->update(['is_active' => !$config->is_active]);
        return response()->json(['status' => 'ok', 'is_active' => $config->is_active]);
    }
}