<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MobileBrand;
use App\Models\MobileModel;
use App\Models\MobileVariant;
use App\Models\VariantQuestion;
use App\Models\VariantDefect;
use App\Models\VariantProblem;
use App\Models\VariantAccessory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VariantQuestionsController extends Controller
{
    // ─────────────────────────────
    // COMMON PAGE (used by flat /admin/questions route)
    // ─────────────────────────────
   public function commonIndex()
{
    $questions = VariantQuestion::whereNull('mobile_variant_id')
                    ->orderBy('sort_order')->get();

    $defects   = VariantDefect::whereNull('mobile_variant_id')
                    ->orderBy('sort_order')->get();

    $problems  = VariantProblem::whereNull('mobile_variant_id')
                    ->get();
 $accessories = VariantAccessory::orderBy('sort_order')->get();
    $variant = (object)['memory' => 'Common'];

    return view('admin.mobile.variants.questions.index',
        compact('questions', 'defects', 'variant', 'problems', 'accessories'));
}

    // ─────────────────────────────
    // VARIANT PAGE (for nested variant-specific route if needed later)
    // ─────────────────────────────
    public function index(MobileBrand $brand, MobileModel $model, MobileVariant $variant)
    {
        $questions = VariantQuestion::where(function($q) use ($variant) {
                        $q->where('mobile_variant_id', $variant->id)
                          ->orWhereNull('mobile_variant_id');
                    })->orderBy('sort_order')->get();

        $defects = VariantDefect::where(function($q) use ($variant) {
                        $q->where('mobile_variant_id', $variant->id)
                          ->orWhereNull('mobile_variant_id');
                    })->orderBy('sort_order')->get();
                     $problems  = $variant->variantProblems()->get();

        return view('admin.mobile.variants.questions.index',
            compact('brand', 'model', 'variant', 'questions', 'defects', 'problems'));
    }

    // ─────────────────────────────
    // STORE COMMON QUESTIONS
    // ─────────────────────────────
    public function storeCommonQuestions(Request $request)
    {
        $request->validate([
            'questions'                      => 'required|array|min:1',
            'questions.*.question'           => 'required|string|max:255',
            'questions.*.small_description'  => 'nullable|string|max:500',
            'questions.*.yes_answer'         => 'required|string|max:100',
            'questions.*.no_answer'          => 'required|string|max:100',
        ]);

        $lastOrder = VariantQuestion::whereNull('mobile_variant_id')->max('sort_order') ?? 0;

        foreach ($request->questions as $i => $q) {
            VariantQuestion::create([
                'mobile_variant_id' => null,
                'question'          => $q['question'],
                'small_description' => $q['small_description'] ?? null,
                'yes_answer'        => $q['yes_answer'],
                'no_answer'         => $q['no_answer'],
                'sort_order'        => $lastOrder + $i + 1,
            ]);
        }

        return back()->with('success', 'Questions Added!');
    }

    // ─────────────────────────────
    // STORE COMMON DEFECTS
    // ─────────────────────────────
    public function storeCommonDefects(Request $request)
    {
        $request->validate([
            'defects'               => 'required|array|min:1',
            'defects.*.image'       => 'required|image|mimes:jpeg,png,jpg,webp,avif|max:2048',
            'defects.*.description' => 'required|string|max:255',
        ]);

        $lastOrder = VariantDefect::whereNull('mobile_variant_id')->max('sort_order') ?? 0;

        foreach ($request->defects as $i => $d) {
            $path = $d['image']->store('defects', 'public');

            VariantDefect::create([
                'mobile_variant_id' => null,
                'image'             => $path,
                'description'       => $d['description'],
                'sort_order'        => $lastOrder + $i + 1,
            ]);
        }

        return back()->with('success', 'Defects Added!');
    }

    // ─────────────────────────────
    // UPDATE QUESTION
    // ─────────────────────────────
    public function updateQuestion(Request $request, VariantQuestion $question)
    {
        $request->validate([
            'question'          => 'required|string|max:255',
            'small_description' => 'nullable|string|max:500',
            'yes_answer'        => 'required|string|max:100',
            'no_answer'         => 'required|string|max:100',
        ]);

        $question->update($request->only('question', 'small_description', 'yes_answer', 'no_answer'));

        return back()->with('success', 'Question updated!');
    }

    // ─────────────────────────────
    // DELETE QUESTION
    // ─────────────────────────────
    public function destroyQuestion(VariantQuestion $question)
    {
        $question->delete();
        return back()->with('success', 'Question deleted!');
    }

    // ─────────────────────────────
    // UPDATE DEFECT
    // ─────────────────────────────
    public function updateDefect(Request $request, VariantDefect $defect)
    {
        $request->validate([
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp,avif|max:2048',
            'description' => 'required|string|max:255',
        ]);

        $data = ['description' => $request->description];

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($defect->image);
            $data['image'] = $request->file('image')->store('defects', 'public');
        }

        $defect->update($data);

        return back()->with('success', 'Defect updated!');
    }

    // ─────────────────────────────
    // DELETE DEFECT
    // ─────────────────────────────
    public function destroyDefect(VariantDefect $defect)
    {
        Storage::disk('public')->delete($defect->image);
        $defect->delete();
        return back()->with('success', 'Defect deleted!');
    }

    // ─────────────────────────────
    // STORE VARIANT QUESTIONS (keep for future use)
    // ─────────────────────────────
    public function storeQuestions(Request $request, MobileBrand $brand, MobileModel $model, MobileVariant $variant)
    {
        $request->validate([
            'questions'                      => 'required|array|min:1',
            'questions.*.question'           => 'required|string|max:255',
            'questions.*.small_description'  => 'nullable|string|max:500',
            'questions.*.yes_answer'         => 'required|string|max:100',
            'questions.*.no_answer'          => 'required|string|max:100',
        ]);

        $lastOrder = VariantQuestion::where('mobile_variant_id', $variant->id)->max('sort_order') ?? 0;

        foreach ($request->questions as $i => $q) {
            VariantQuestion::create([
                'mobile_variant_id' => $variant->id,
                'question'          => $q['question'],
                'small_description' => $q['small_description'] ?? null,
                'yes_answer'        => $q['yes_answer'],
                'no_answer'         => $q['no_answer'],
                'sort_order'        => $lastOrder + $i + 1,
            ]);
        }

        return back()->with('success', 'Variant Questions Added!');
    }

    // ─────────────────────────────
    // STORE VARIANT DEFECTS (keep for future use)
    // ─────────────────────────────
    public function storeDefects(Request $request, MobileBrand $brand, MobileModel $model, MobileVariant $variant)
    {
        $request->validate([
            'defects'               => 'required|array|min:1',
            'defects.*.image'       => 'required|image|mimes:jpeg,png,jpg,webp,avif|max:2048',
            'defects.*.description' => 'required|string|max:255',
        ]);

        $lastOrder = VariantDefect::where('mobile_variant_id', $variant->id)->max('sort_order') ?? 0;

        foreach ($request->defects as $i => $d) {
            $path = $d['image']->store('defects', 'public');

            VariantDefect::create([
                'mobile_variant_id' => $variant->id,
                'image'             => $path,
                'description'       => $d['description'],
                'sort_order'        => $lastOrder + $i + 1,
            ]);
        }

        return back()->with('success', 'Variant Defects Added!');
    }

    public function problems()
{
    return $this->hasMany(VariantProblem::class)->orderBy('order');
}
}