<?php
// ═══════════════════════════════════════════════════════════════════
// app/Http/Controllers/Admin/AdminLaptopQuestionController.php
// ═══════════════════════════════════════════════════════════════════
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LaptopQuestion;
use App\Models\LaptopQuestionOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminLaptopQuestionController extends Controller
{
    private array $groups = [
        'additional_features' => 'Additional Features',
        'device_condition'    => 'Device Condition',
        'screen_condition'    => 'Screen Condition',
        'accessories'         => 'Accessories',
        'device_age'          => 'Device Age',          // ✅ ADD
        'physical_condition'  => 'Physical Condition',  // ✅ ADD
    ];

    public function index()
    {
        $questions = LaptopQuestion::with('options')
            ->orderBy('question_group')
            ->orderBy('sort_order')
            ->get();

        return view('admin.laptop.questions', [
            'questions' => $questions,
            'groups'    => $this->groups,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'question'       => 'required|string|max:500',
            'small_description' => 'nullable|string|max:500',
            'question_group' => 'required|in:additional_features,device_condition,screen_condition,accessories,device_age,physical_condition',
            'input_type'     => 'required|in:radio,multi_select',
            'sort_order'     => 'nullable|integer|min:0',
        ]);

        LaptopQuestion::create($request->only([
            'question', 'small_description', 'question_group', 'input_type', 'sort_order'
        ]));

        return back()->with('success', 'Question added successfully.');
    }

    public function update(Request $request, $id)
    {
        $q = LaptopQuestion::findOrFail($id);
        $q->update($request->only([
            'question', 'small_description', 'question_group',
            'input_type', 'sort_order', 'is_active'
        ]));
        return back()->with('success', 'Question updated.');
    }

    public function destroy($id)
    {
        LaptopQuestion::findOrFail($id)->delete();
        return back()->with('success', 'Question deleted.');
    }

    // ── Options ──────────────────────────────────────────────────

    public function storeOption(Request $request, $qid)
    {
        $request->validate([
            'label'        => 'required|string|max:255',
            'option_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'deduction'    => 'nullable|integer|min:0',
            'sort_order'   => 'nullable|integer|min:0',
        ]);

        $data = $request->only(['label', 'deduction', 'sort_order']);
        $data['icon_emoji'] = $request->input('icon_emoji'); // optional, kept

        if ($request->hasFile('option_image')) {
            $data['option_image'] = $request->file('option_image')
                ->store('laptop_options', 'public');
        }

        LaptopQuestion::findOrFail($qid)->options()->create($data);
        return back()->with('success', 'Option added.');
    }

    public function updateOption(Request $request, $oid)
    {
        $opt = LaptopQuestionOption::findOrFail($oid);

        $request->validate([
            'label'        => 'required|string|max:255',
            'option_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'deduction'    => 'nullable|integer|min:0',
            'sort_order'   => 'nullable|integer|min:0',
        ]);

        $data = $request->only(['label', 'deduction', 'sort_order', 'icon_emoji']);

        if ($request->hasFile('option_image')) {
            // Delete old image
            if ($opt->option_image) {
                Storage::disk('public')->delete($opt->option_image);
            }
            $data['option_image'] = $request->file('option_image')
                ->store('laptop_options', 'public');
        }

        // Allow explicit removal
        if ($request->input('remove_image') == '1' && $opt->option_image) {
            Storage::disk('public')->delete($opt->option_image);
            $data['option_image'] = null;
        }

        $opt->update($data);
        return back()->with('success', 'Option updated.');
    }

    public function destroyOption($oid)
    {
        $opt = LaptopQuestionOption::findOrFail($oid);
        if ($opt->option_image) {
            Storage::disk('public')->delete($opt->option_image);
        }
        $opt->delete();
        return back()->with('success', 'Option deleted.');
    }
}