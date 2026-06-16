<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MobileQuestion;
use Illuminate\Http\Request;

class MobileQuestionsController extends Controller
{
    /**
     * Show all global mobile questions
     */
    public function index()
    {
        $questions = MobileQuestion::orderBy('sort_order')->get();
        return view('admin.mobile.questions.index', compact('questions'));
    }

    /**
     * Store multiple questions at once
     */
    public function store(Request $request)
    {
        $request->validate([
            'questions'                     => 'required|array|min:1',
            'questions.*.question'          => 'required|string|max:255',
            'questions.*.small_description' => 'nullable|string|max:500',
            'questions.*.yes_answer'        => 'required|string|max:100',
            'questions.*.no_answer'         => 'required|string|max:100',
        ]);

        $lastOrder = MobileQuestion::max('sort_order') ?? 0;

        foreach ($request->questions as $i => $q) {
            MobileQuestion::create([
                'question'          => $q['question'],
                'small_description' => $q['small_description'] ?? null,
                'yes_answer'        => $q['yes_answer'],
                'no_answer'         => $q['no_answer'],
                'sort_order'        => $lastOrder + $i + 1,
            ]);
        }

        return redirect()->route('mobile.questions.index')
            ->with('success', 'Questions added successfully!');
    }

    /**
     * Update a single question
     */
    public function update(Request $request, MobileQuestion $question)
    {
        $request->validate([
            'question'          => 'required|string|max:255',
            'small_description' => 'nullable|string|max:500',
            'yes_answer'        => 'required|string|max:100',
            'no_answer'         => 'required|string|max:100',
        ]);

        $question->update($request->only('question', 'small_description', 'yes_answer', 'no_answer'));

        return redirect()->route('mobile.questions.index')
            ->with('success', 'Question updated!');
    }

    /**
     * Delete a question
     */
    public function destroy(MobileQuestion $question)
    {
        $question->delete();

        return redirect()->route('mobile.questions.index')
            ->with('success', 'Question deleted!');
    }
}
