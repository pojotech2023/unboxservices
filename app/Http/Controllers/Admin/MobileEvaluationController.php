<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\DeviceEvaluation;
use App\Models\MobileBrand;
use App\Models\VariantQuestion;
use App\Models\VariantDefect;
use App\Models\DefectSection;
use App\Models\DefectSectionImage;
use App\Models\VariantProblem;
use App\Models\VariantAccessory;
use Illuminate\Http\Request;

class MobileEvaluationController extends Controller
{
     public function index(Request $request)
    {
        $query = DeviceEvaluation::with(['brand', 'model', 'variant'])
    ->where('device_type', 'mobile')
    ->where('status', 'confirmed')
    ->latest();

// Search
if ($request->filled('search')) {
    $s = $request->search;
    $query->where(function ($q) use ($s) {
        $q->where('customer_name', 'like', "%$s%")
          ->orWhere('customer_mobile', 'like', "%$s%");
    });
}

// Brand filter
if ($request->filled('brand_id')) {
    $query->where('brand_id', $request->brand_id);
}

// Date filter
if ($request->filled('date')) {
    $query->whereDate('created_at', $request->date);
}

$evaluations = $query->paginate(15);

// ✅ Stats (ONLY CONFIRMED)
$baseQuery = DeviceEvaluation::where('device_type', 'mobile')
    ->where('status', 'confirmed');

$totalCount = $baseQuery->count();
$totalValue = $baseQuery->sum('estimated_price');
$avgPrice   = $baseQuery->avg('estimated_price') ?? 0;

$todayCount = DeviceEvaluation::where('device_type', 'mobile')
    ->where('status', 'confirmed')
    ->whereDate('created_at', today())
    ->count();

$brands = MobileBrand::orderBy('name')->get();

return view('admin.evaluations.mobile.index', compact(
    'evaluations',
    'brands',
    'totalCount',
    'totalValue',
    'avgPrice',
    'todayCount'
));    }
 
   public function show(DeviceEvaluation $evaluation)
{
    // Parse JSON answers
    $answers = is_array($evaluation->answers) 
    ? $evaluation->answers 
    : (json_decode($evaluation->answers, true) ?? []);
    
    // Get all mapping data for IDs to Names
    $evalAnswers = $answers['eval_answers'] ?? [];
    $defectIds = $answers['defect_ids'] ?? [];
    $sectionAnswers = $answers['section_answers'] ?? [];
    $problemIds = $answers['problem_ids'] ?? [];
    $accessoryIds = $answers['accessory_ids'] ?? [];
    
    // 1. Evaluation Questions with Answers
    $questionsMap = [];
    if (!empty($evalAnswers)) {
        $questionIds = array_keys($evalAnswers);
        $questions = VariantQuestion::whereIn('id', $questionIds)->get()->keyBy('id');
        
        foreach ($evalAnswers as $qId => $answer) {
            $question = $questions->get($qId);
            $questionsMap[] = [
                'question_id' => $qId,
                'question_text' => $question->question ?? 'Unknown Question #'.$qId,
                'answer' => $answer,
                'answer_text' => $answer === 'yes' ? ($question->yes_answer ?? 'Yes') : ($question->no_answer ?? 'No')
            ];
        }
    }
    
    // 2. Defects with Section Answers
    $defectsMap = [];
    if (!empty($defectIds)) {
        $defects = VariantDefect::whereIn('id', $defectIds)->get()->keyBy('id');
        
        foreach ($defectIds as $defectId) {
            $defect = $defects->get($defectId);
            $sections = [];
            
            // Get section answers for this defect
            if (isset($sectionAnswers[$defectId])) {
                foreach ($sectionAnswers[$defectId] as $sectionId => $imageId) {
                    $section = DefectSection::find($sectionId);
                    $image = DefectSectionImage::find($imageId);
                    
                    $sections[] = [
                        'section_id' => $sectionId,
                        'section_name' => $section->name ?? 'Unknown Section',
                        'image_id' => $imageId,
                        'image_description' => $image->description ?? 'Unknown'
                    ];
                }
            }
            
            $defectsMap[] = [
                'defect_id' => $defectId,
                'defect_name' => $defect->name ?? 'Unknown Defect #'.$defectId,
                'sections' => $sections
            ];
        }
    }
    
    // 3. Problems
    $problemsMap = [];
    if (!empty($problemIds)) {
        $problems = VariantProblem::whereIn('id', $problemIds)->get()->keyBy('id');
        
        foreach ($problemIds as $probId) {
            $problem = $problems->get($probId);
            $problemsMap[] = [
                'problem_id' => $probId,
                'problem_name' => $problem->description ?? 'Unknown Problem #'.$probId
            ];
        }
    }
    
    // 4. Accessories
    $accessoriesMap = [];
    if (!empty($accessoryIds)) {
        $accessories = VariantAccessory::whereIn('id', $accessoryIds)->get()->keyBy('id');
        
        foreach ($accessoryIds as $accId) {
            $accessory = $accessories->get($accId);
            $accessoriesMap[] = [
                'accessory_id' => $accId,
                'accessory_name' => $accessory->description ?? 'Unknown Accessory #'.$accId
            ];
        }
    }
    
    return view('admin.evaluations.mobile.show', compact(
        'evaluation',
        'questionsMap',
        'defectsMap', 
        'problemsMap',
        'accessoriesMap'
    ));

    }
    public function destroy(DeviceEvaluation $evaluation)
    {
        $evaluation->delete();
        return redirect()->route('admin.evaluations.mobile.index')
                         ->with('success', 'Evaluation deleted successfully.');
    }
 
    // Optional: Export to Excel (needs maatwebsite/excel package)
    public function export()
    {
        // Implement if needed using Laravel Excel
        // return Excel::download(new MobileEvaluationsExport, 'evaluations.xlsx');
        abort(501, 'Export not implemented yet.');
    }
}
 

