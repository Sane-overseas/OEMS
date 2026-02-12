<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Exam;

class ExamController extends Controller
{
    public function index()
    {
        $student = Auth::user();

        $exams = Exam::where('school_id', $student->school_id)
            ->where('class', $student->grade)
            ->where('status', 'published')
            ->with('schedule')
            ->latest()
            ->paginate(10);

        return view('student.exams.index', compact('exams'));
    }

    public function live($id)
    {
        $student = Auth::user();
        $now = now();

        $exam = Exam::where('school_id', $student->school_id)
            ->where('id', $id)
            ->where('status', 'published')
            ->with(['schedule'])
            ->firstOrFail();

        // Check if exam is live based on schedule
        if (!$exam->schedule || !$now->between($exam->schedule->start_at, $exam->schedule->end_at)) {
            return redirect()->route('student.exams.index')->with('error', 'This exam is not currently live.');
        }

        // Fetch questions for Set A (Defaulting to Set A for now)
        $questions = $exam->questions()
            ->wherePivot('set_code', 'A')
            ->with('options')
            ->orderBy('pivot_serial_no')
            ->get();

        // Prepare data for JS frontend
        $questionsData = $questions->map(function ($q) {
            return [
                'id' => $q->id,
                'text' => $q->question_text,
                'marks' => $q->pivot->marks,
                'options' => $q->options->map(function ($o) {
                    return [
                        'id' => $o->id,
                        'text' => $o->option_text
                    ];
                })->values()
            ];
        })->values();

        return view('student.exams.live', compact('exam', 'questionsData'));
    }

    public function submit(Request $request, $id)
    {
        $student = Auth::user();
        $exam = Exam::findOrFail($id);

        $answers = $request->input('answers', []);

        // If it's a string (JSON or comma separated), decode it
        if (is_string($answers)) {
            $decoded = json_decode($answers, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $answers = $decoded;
            } else {
                // If not JSON, maybe CSV-like: "1=3,2=5"
                $answersArray = [];
                foreach (explode(',', $answers) as $pair) {
                    [$qId, $optionId] = explode('=', $pair);
                    $answersArray[$qId] = $optionId;
                }
                $answers = $answersArray;
            }
        }

        $totalQuestions = count($answers);
        $totalCorrect = 0;

        // Start exam attempt
        $attempt = \App\Models\ExamAttempt::create([
            'school_id' => $student->school_id,
            'user_id' => $student->id,
            'exam_id' => $exam->id,
            'total_questions' => $totalQuestions,
            'total_correct' => 0, // will update later
            'score' => 0,         // will update later
            'started_at' => now(),
            'submitted_at' => now(),
        ]);

        foreach ($answers as $questionId => $selectedOptionId) {
            $question = \App\Models\Question::find($questionId);
            $isCorrect = $question && $question->correct_option_id == $selectedOptionId ? 1 : 0;

            if ($isCorrect) {
                $totalCorrect++;
            }

            \App\Models\UserExamAnswer::create([
                'school_id' => $student->school_id,
                'attempt_id' => $attempt->id,
                'user_id' => $student->id,
                'exam_id' => $exam->id,
                'question_id' => $questionId,
                'selected_option_id' => $selectedOptionId,
                'is_correct' => $isCorrect,
            ]);
        }

        // Update attempt with correct count and score
        $score = ($totalCorrect / $totalQuestions) * 100;

        $attempt->update([
            'total_correct' => $totalCorrect,
            'score' => $score,
        ]);

        return redirect()->route('student.exams.index')->with('success', 'Exam submitted successfully!');
    }
}
