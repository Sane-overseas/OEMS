<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\QuestionOption;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
    public function index()
    {
        $admin = auth('admin')->user();

        $questions = Question::where('school_id', $admin->school_id)
            ->latest()->paginate(20);

        return view('admin.questions.index', compact('questions'));
    }

    public function create()
    {
        return view('admin.questions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'class' => 'required',
            'subject' => 'required',
            'question' => 'required',
            'marks' => 'required|integer|min:1',
            'options' => 'required|array|min:2',
            'correct' => 'required'
        ]);

        $admin = auth('admin')->user();

        DB::transaction(function () use ($request, $admin) {

            $q = Question::create([
                'school_id' => $admin->school_id,
                'class' => $request->class,
                'subject' => $request->subject,
                'question' => $request->question,
                'marks' => $request->marks,
            ]);

            foreach ($request->options as $i => $text) {
                QuestionOption::create([
                    'question_id' => $q->id,
                    'option_text' => $text,
                    'is_correct' => ((string) $i === (string) $request->correct)
                ]);
            }
        });

        return redirect()->route(
            $request->has('save_add_more')
            ? 'admin.questions.create'
            : 'admin.questions.index'
        );
    }

    public function bulkForm()
    {
        return view('admin.questions.bulk-upload');
    }
    public function bulkUpload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt'
        ]);

        $admin = auth('admin')->user();

        $file = fopen($request->file('file')->getRealPath(), 'r');

        $header = fgetcsv($file);

        DB::beginTransaction();

        try {

            while (($row = fgetcsv($file)) !== false) {

                /*
                 Expected columns:

                 0 = grade
                 1 = subject
                 2 = question
                 3 = marks
                 4 = option_a
                 5 = option_b
                 6 = option_c
                 7 = option_d
                 8 = correct_option (A/B/C/D)
                */

                if (count($row) < 9) {
                    continue;
                }

                $question = Question::create([
                    'school_id' => $admin->school_id,
                    'class' => trim($row[0]),
                    'subject' => trim($row[1]),
                    'question' => trim($row[2]),
                    'marks' => (int) $row[3],
                ]);

                $options = [
                    'A' => $row[4],
                    'B' => $row[5],
                    'C' => $row[6],
                    'D' => $row[7],
                ];

                $correct = strtoupper(trim($row[8]));

                foreach ($options as $key => $text) {

                    QuestionOption::create([
                        'question_id' => $question->id,
                        'option_text' => trim($text),
                        'is_correct' => ($key === $correct),
                    ]);
                }
            }

            DB::commit();

        } catch (\Throwable $e) {

            DB::rollBack();
            throw $e;
        }

        return redirect()
            ->route('admin.questions.index')
            ->with('success', 'Questions uploaded successfully.');
    }

}
