<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\School;
use App\Models\Exam;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'student')->with('school');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('admission_number', 'like', "%{$search}%");
            });
        }

        if ($request->filled('school_id')) {
            $query->where('school_id', $request->school_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $students = $query->latest()->paginate(15);
        $schools = School::where('status', 'active')->get();

        return view('superadmin.students.index', compact('students', 'schools'));
    }

    public function show($id)
    {
        $student = User::where('role', 'student')->with('school')->findOrFail($id);
        $schools = School::where('status', 'active')->where('id', '!=', $student->school_id)->get();
        
        // Fetch exams belonging to the student's school for the reset attempt dropdown
        $exams = Exam::where('school_id', $student->school_id)->latest()->get();

        return view('superadmin.students.show', compact('student', 'schools', 'exams'));
    }

    public function toggleStatus($id)
    {
        $student = User::where('role', 'student')->findOrFail($id);
        $student->status = $student->status === 'active' ? 'inactive' : 'active';
        $student->save();

        return back()->with('success', 'Student status updated successfully.');
    }

    public function transfer(Request $request, $id)
    {
        $request->validate([
            'school_id' => 'required|exists:schools,id',
        ]);

        $student = User::where('role', 'student')->findOrFail($id);
        $student->school_id = $request->school_id;
        $student->save();

        return back()->with('success', 'Student transferred successfully.');
    }

    public function resetExam(Request $request, $id)
    {
        $request->validate([
            'exam_id' => 'required|exists:exams,id',
        ]);

        // Logic to delete exam attempt would go here.
        // Assuming an ExamAttempt model or table exists.
        // DB::table('exam_attempts')->where('user_id', $id)->where('exam_id', $request->exam_id)->delete();

        return back()->with('success', 'Exam attempt reset successfully.');
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'selected_students' => 'required|array',
            'selected_students.*' => 'exists:users,id',
            'action' => 'required|in:block,unblock,transfer',
            'transfer_school_id' => 'required_if:action,transfer|nullable|exists:schools,id',
        ]);

        $students = User::whereIn('id', $request->selected_students)->where('role', 'student');

        switch ($request->action) {
            case 'block':
                $students->update(['status' => 'inactive']);
                $message = 'Selected students have been blocked.';
                break;
            case 'unblock':
                $students->update(['status' => 'active']);
                $message = 'Selected students have been unblocked.';
                break;
            case 'transfer':
                if ($request->transfer_school_id) {
                    $students->update(['school_id' => $request->transfer_school_id]);
                    $message = 'Selected students have been transferred.';
                } else {
                    return back()->with('error', 'Please select a school to transfer to.');
                }
                break;
        }

        return back()->with('success', $message ?? 'Action completed.');
    }
}
