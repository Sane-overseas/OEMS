<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\ExamSchedule;
use Illuminate\Support\Facades\Auth;

class ExamScheduleController extends Controller
{
    public function create($id)
    {
        $admin = auth('admin')->user();

        $exam = Exam::with('schedule')->where('school_id', $admin->school_id)
            ->findOrFail($id);

        return view('admin.exams.schedule', compact('exam'));
    }

    public function store(Request $request, $id)
    {

        $request->validate([
            'start_at' => 'required',
            'end_at' => 'required|after:start_at',
        ]);

        $admin = auth('admin')->user();

        $exam = Exam::where('school_id', $admin->school_id)
            ->findOrFail($id);

        $exam->schedule()->updateOrCreate(
            ['exam_id' => $exam->id],   
            [
                'start_at' => $request->start_at,
                'end_at' => $request->end_at,
                'late_entry_allowed' => $request->has('late_entry_allowed'),
                'late_entry_minutes' => $request->late_entry_minutes ?? 0,
                'max_attempts' => $request->max_attempts ?? 1,
            ]
        );

        return redirect()->route('admin.exams.index');
    }

}
