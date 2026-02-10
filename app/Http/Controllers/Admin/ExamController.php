<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExamController extends Controller
{
    public function index()
    {
        $admin = auth('admin')->user();

        $exams = Exam::with('schedule')->withCount('questions')->where('school_id', $admin->school_id)
            ->latest()->paginate(20);

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
            'grade' => 'required',
            'subject' => 'required',
            'academic_session' => 'required',
            'exam_type' => 'required',
            'duration_minutes' => 'required|integer|min:1',
        ]);

        $admin = auth('admin')->user();

        $exam = Exam::create([
            'school_id' => $admin->school_id,
            'created_by' => $admin->id,
            'title' => $request->title,
            'grade' => $request->grade,
            'subject' => $request->subject,
            'academic_session' => $request->academic_session,
            'exam_type' => $request->exam_type,
            'duration_minutes' => $request->duration_minutes,
            'pass_marks' => $request->pass_marks,
            'negative_marking' => $request->negative_marking ?? 0,
            'negative_marks' => $request->negative_marks ?? 0,
            'shuffle_questions' => $request->shuffle_questions ?? 0,
            'shuffle_options' => $request->shuffle_options ?? 0,
            'instructions' => json_encode(
                array_values(array_filter($request->instructions ?? []))
            ),
            'status' => 'draft'
        ]);

        return redirect()->route('admin.exams.questions', $exam->id);
    }

    // professional attach screen
    public function questions($id)
    {
        $admin = auth('admin')->user();

        $exam = Exam::with('questions')
            ->where('school_id', $admin->school_id)
            ->findOrFail($id);

        $questions = Question::where('school_id', $admin->school_id)
            ->where('grade', $exam->grade)
            ->get();

        $attached = $exam->questions->pluck('id')->toArray();

        return view('admin.exams.questions', compact('exam', 'questions', 'attached'));
    }
    public function attachQuestions(Request $request, $id)
    {
        $admin = auth('admin')->user();

        $exam = Exam::where('school_id', $admin->school_id)
            ->findOrFail($id);

        $request->validate([
            'questions' => 'required|array'
        ]);

        $questions = Question::whereIn('id', $request->questions)
            ->where('school_id', $admin->school_id)
            ->get();


        $sets = $exam->shuffle_questions
            ? ['A', 'B', 'C', 'D']
            : ['A'];

        $rows = [];
        $totalMarks = $questions->sum('marks');

        foreach ($sets as $set) {

            $list = $exam->shuffle_questions
                ? $questions->shuffle()->values()
                : $questions->values();

            $serial = 1;

            foreach ($list as $q) {

                $rows[] = [
                    'exam_id' => $exam->id,
                    'question_id' => $q->id,
                    'set_code' => $set,
                    'serial_no' => $serial++,
                    'marks' => $q->marks,
                ];
            }
        }

        // remove old mapping
        DB::table('exam_question')
            ->where('exam_id', $exam->id)
            ->delete();

        // insert new sets
        DB::table('exam_question')->insert($rows);

        $exam->update([
            'total_marks' => $totalMarks
        ]);

        return redirect()->route('admin.exams.schedule', $exam->id);
    }


    public function publish($id)
    {
        $admin = auth('admin')->user();

        $exam = Exam::where('school_id', $admin->school_id)->findOrFail($id);

        if ($exam->questions()->count() == 0)
            return back()->with('error', 'Attach questions first');

        if (!$exam->schedule)
            return back()->with('error', 'Schedule exam first');

        $exam->update(['status' => 'published']);

        return back();
    }

    public function close($id)
    {
        $admin = auth('admin')->user();

        $exam = Exam::where('school_id', $admin->school_id)->findOrFail($id);

        $exam->update(['status' => 'closed']);

        return back();
    }

    public function show(Request $request, $id)
    {
        $admin = auth('admin')->user();

        $set = $request->get('set', 'A');   // default A

        $exam = Exam::with(['schedule'])
            ->where('school_id', $admin->school_id)
            ->findOrFail($id);

        $questions = $exam->questions()
            ->wherePivot('set_code', $set)
            ->orderBy('pivot_serial_no')
            ->get();

        $sets = \DB::table('exam_question')
            ->where('exam_id', $exam->id)
            ->select('set_code')
            ->distinct()
            ->orderBy('set_code')
            ->pluck('set_code');

        return view('admin.exams.show', compact('exam', 'questions', 'set', 'sets'));
    }


    public function edit($id)
    {
        $admin = auth('admin')->user();

        $exam = Exam::where('school_id', $admin->school_id)
            ->findOrFail($id);

        if ($exam->status === 'closed') {
            return back()->with('error', 'Closed exam cannot be edited.');
        }

        return view('admin.exams.edit', compact('exam'));
    }
    public function update(Request $request, $id)
    {
        $admin = auth('admin')->user();

        $exam = Exam::where('school_id', $admin->school_id)
            ->findOrFail($id);

        if ($exam->status === 'closed') {
            return back()->with('error', 'Closed exam cannot be edited.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'exam_type' => 'required|string',
            'duration_minutes' => 'required|integer|min:1',
            'pass_marks' => 'nullable|integer|min:0'
        ]);

        $exam->update([
            'title' => $request->title,
            'exam_type' => $request->exam_type,
            'duration_minutes' => $request->duration_minutes,
            'pass_marks' => $request->pass_marks,
        ]);

        return redirect()
            ->route('admin.exams.show', $exam->id)
            ->with('success', 'Exam updated successfully.');
    }


}
