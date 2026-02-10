<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    public function index()
    {
        $admin = Auth::guard('admin')->user();

        $exams = Exam::where('school_id', $admin->school_id)
            ->latest()
            ->paginate(20);

        return view('admin.exams.index', compact('exams'));
    }

    public function create()
    {
        return view('admin.exams.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'class' => 'required',
            'subject' => 'required',
            'duration_minutes' => 'required|integer|min:1'
        ]);

        $admin = Auth::guard('admin')->user();

        $exam = Exam::create([
            'school_id' => $admin->school_id,
            'title' => $request->title,
            'class' => $request->class,
            'subject' => $request->subject,
            'duration_minutes' => $request->duration_minutes,
            'instructions' => $request->instructions,
            'status' => 'draft',
            'created_by' => $admin->id
        ]);

        return redirect()
            ->route('admin.exams.edit-questions', $exam->id);
    }

    // Attach questions screen
    public function editQuestions($id)
    {
        $admin = Auth::guard('admin')->user();

        $exam = Exam::where('school_id', $admin->school_id)
            ->findOrFail($id);

        $questions = Question::where('school_id', $admin->school_id)
            ->where('class', $exam->class)
            ->where('subject', $exam->subject)
            ->get();

        return view('admin.exams.questions', compact('exam','questions'));
    }

    public function attachQuestions(Request $request, $id)
    {
        $admin = Auth::guard('admin')->user();

        $exam = Exam::where('school_id', $admin->school_id)
            ->findOrFail($id);

        $request->validate([
            'questions' => 'required|array'
        ]);

        $exam->questions()->sync([]);

        $total = 0;

        foreach ($request->questions as $qid) {

            $q = Question::findOrFail($qid);

            $exam->questions()->attach($qid, [
                'marks' => $q->marks
            ]);

            $total += $q->marks;
        }

        $exam->update([
            'total_marks' => $total
        ]);

        return redirect()
            ->route('admin.exams.index')
            ->with('success','Questions attached successfully');
    }
    public function publish($id)
{
    $admin = auth()->guard('admin')->user();

    $exam = Exam::where('school_id', $admin->school_id)
        ->findOrFail($id);

    // must have questions before publish
    if ($exam->questions()->count() == 0) {
        return back()->with('error', 'Please attach questions before publishing.');
    }

    $exam->update([
        'status' => 'published'
    ]);

    return back()->with('success', 'Exam published successfully.');
}

public function close($id)
{
    $admin = auth()->guard('admin')->user();

    $exam = Exam::where('school_id', $admin->school_id)
        ->findOrFail($id);

    $exam->update([
        'status' => 'closed'
    ]);

    return back()->with('success', 'Exam closed.');
}

}
