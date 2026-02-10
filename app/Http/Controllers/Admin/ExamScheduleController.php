<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\ExamSchedule;
use Illuminate\Support\Facades\Auth;

class ExamScheduleController extends Controller
{
      public function create($examId)
    {
        $admin = auth()->guard('admin')->user();

        $exam = Exam::where('school_id',$admin->school_id)
            ->findOrFail($examId);

        return view('admin.exams.schedule', compact('exam'));
    }

    public function store(Request $request, $examId)
    {
        $request->validate([
            'start_at' => 'required|date',
            'end_at'   => 'required|date|after:start_at'
        ]);

        $admin = auth()->guard('admin')->user();

        $exam = Exam::where('school_id',$admin->school_id)
            ->findOrFail($examId);

        ExamSchedule::updateOrCreate(
            ['exam_id' => $exam->id],
            [
                'start_at' => $request->start_at,
                'end_at'   => $request->end_at
            ]
        );

        return redirect()
            ->route('admin.exams.index')
            ->with('success','Exam scheduled successfully');
    }
}
