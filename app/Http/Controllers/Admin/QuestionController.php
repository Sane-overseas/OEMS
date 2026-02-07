<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\QuestionOption;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
      public function index()
    {
        $admin = Auth::guard('admin')->user();

        $questions = Question::where('school_id', $admin->school_id)
            ->latest()
            ->paginate(20);

        return view('admin.questions.index', compact('questions'));
    }

    public function create()
    {
        return view('admin.questions.create');
    }

     public function store(Request $request)
    {
        $request->validate([
            'class'   => 'required|string|max:100',
            'subject' => 'required|string|max:100',
            'question_text' => 'required|string',
            'marks'   => 'required|integer|min:1',

            'options' => 'required|array|min:4',
            'options.*' => 'required|string',

            'correct_option' => 'required|integer'
        ]);

        $admin = Auth::guard('admin')->user();

        $question = Question::create([
            'school_id'     => $admin->school_id,
            'class'         => $request->class,
            'subject'       => $request->subject,
            'type'          => 'mcq',
            'question_text' => $request->question_text,
            'marks'         => $request->marks,
            'difficulty'    => $request->difficulty,
            'created_by'    => $admin->id,
            'status'        => 'active'
        ]);

        foreach ($request->options as $index => $optionText) {

            QuestionOption::create([
                'question_id' => $question->id,
                'option_text' => $optionText,
                'is_correct'  => ($index == $request->correct_option)
            ]);
        }

        return redirect()
            ->route('admin.questions.index')
            ->with('success', 'Question created successfully');
    }
}
