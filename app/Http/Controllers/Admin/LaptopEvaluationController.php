<?php
// app/Http/Controllers/Admin/LaptopEvaluationController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LaptopDeviceEvaluation;
use App\Models\LaptopBrand;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaptopEvaluationsExport;

class LaptopEvaluationController extends Controller
{
   public function index(Request $request)
{
    $query = LaptopDeviceEvaluation::with(['brand', 'model', 'variant'])->where('status','confirmed')
        ->latest();

    // Search filter
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('customer_name', 'like', "%{$search}%")
              ->orWhere('customer_mobile', 'like', "%{$search}%");
        });
    }

    // Brand filter
    if ($request->filled('brand_id')) {
        $query->where('laptop_brand_id', $request->brand_id);
    }

    // Date filter
    if ($request->filled('date')) {
        $query->whereDate('created_at', $request->date);
    }

    // Status filter (for listing)
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    $evaluations = $query->paginate(20);

    // ✅ Stats (ONLY CONFIRMED)
    $baseQuery = LaptopDeviceEvaluation::where('status', 'confirmed');

    $totalCount = $baseQuery->count();
    $totalValue = $baseQuery->sum('estimated_price');
    $avgPrice   = $baseQuery->avg('estimated_price') ?? 0;

    $todayCount = LaptopDeviceEvaluation::where('status', 'confirmed')
                    ->whereDate('created_at', today())
                    ->count();

    $brands = LaptopBrand::orderBy('name')->get();

    return view('admin.evaluations.laptop.index', compact(
        'evaluations',
        'totalCount',
        'totalValue',
        'todayCount',
        'avgPrice',
        'brands'
    ));
}
public function show($id)
{
    $evaluation = LaptopDeviceEvaluation::with(['brand', 'model', 'variant'])
        ->findOrFail($id);

    // Get all question IDs from answers
    $answers = $evaluation->answers;
    
    // Fetch physical condition questions with options for display
    $physicalConditionDetails = [];
    if (!empty($answers['physical_condition'])) {
        $questionIds = array_keys($answers['physical_condition']);
        
        $questions = \App\Models\LaptopQuestion::whereIn('id', $questionIds)
            ->with(['options' => function($q) use ($answers) {
                // We need all options to find the selected one
            }])
            ->get()
            ->keyBy('id');
        
        foreach ($answers['physical_condition'] as $qId => $optIds) {
            $question = $questions[$qId] ?? null;
            if (!$question) continue;
            
            $selectedOptions = [];
            $optIdArray = is_array($optIds) ? $optIds : [$optIds];
            
            foreach ($optIdArray as $optId) {
                $option = $question->options->firstWhere('id', $optId);
                if ($option) {
                    $selectedOptions[] = $option->label;
                } else {
                    $selectedOptions[] = 'Option #' . $optId;
                }
            }
            
            $physicalConditionDetails[] = [
                'question' => $question->question,
                'selected' => implode(', ', $selectedOptions)
            ];
        }
    }

    // Fetch additional features questions if needed
    $additionalFeatureDetails = [];
    if (!empty($answers['additional_features']) && is_array($answers['additional_features'])) {
        // Additional features are already stored with q and a, so they're good
        $additionalFeatureDetails = $answers['additional_features'];
    }

    return view('admin.evaluations.laptop.show', compact(
        'evaluation', 
        'physicalConditionDetails',
        'additionalFeatureDetails'
    ));
}
    public function destroy($id)
    {
        $evaluation = LaptopDeviceEvaluation::findOrFail($id);
        $evaluation->delete();

        return redirect()->route('admin.evaluations.laptop.index')
            ->with('success', 'Evaluation deleted successfully.');
    }

    public function export()
    {
        return Excel::download(new LaptopEvaluationsExport, 'laptop-evaluations.xlsx');
    }
}