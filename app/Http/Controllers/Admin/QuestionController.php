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

            $q = Question::forceCreate([
                'school_id' => $admin->school_id,
                'class' => $request->class,
                'subject' => $request->subject,
                'question_text' => $request->question,
                'marks' => $request->marks,
                'type' => 'mcq',
                'created_by' => $admin->id,
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

        $header = fgetcsv($file); // Skip header

        $imported = 0;
        $skipped = 0;
        $failed = 0;
        $errors = [];
        $rowNumber = 1;

        while (($row = fgetcsv($file)) !== false) {
            $rowNumber++;

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
                $failed++;
                $errors[] = "Row {$rowNumber}: Insufficient columns.";
                continue;
            }

            $class = trim($row[0]);
            $subject = trim($row[1]);
            $questionText = trim($row[2]);
            $marks = (int) $row[3];

            // Basic validation
            if ($class === '' || $subject === '' || $questionText === '') {
                $failed++;
                $errors[] = "Row {$rowNumber}: Missing required fields (Class, Subject, or Question).";
                continue;
            }

            // Check for duplicate
            $exists = Question::where('school_id', $admin->school_id)
                ->where('class', $class)
                ->where('subject', $subject)
                ->where('question_text', $questionText)
                ->exists();

            if ($exists) {
                $skipped++;
                continue;
            }

            DB::beginTransaction();

            try {
                $question = Question::forceCreate([
                    'school_id' => $admin->school_id,
                    'class' => $class,
                    'subject' => $subject,
                    'question_text' => $questionText,
                    'marks' => $marks > 0 ? $marks : 1,
                    'type' => 'mcq',
                    'created_by' => $admin->id,
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

                DB::commit();
                $imported++;
            } catch (\Throwable $e) {
                DB::rollBack();
                $failed++;
                $errors[] = "Row {$rowNumber}: " . $e->getMessage();
            }
        }

        fclose($file);

        $report = [
            'imported' => $imported,
            'skipped' => $skipped,
            'failed' => $failed,
            'errors' => $errors
        ];

        return redirect()
            ->route('admin.questions.index')
            ->with('bulk_report', $report);
    }

    public function downloadSample()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="questions_import_sample.csv"',
        ];

        $columns = ['Class', 'Subject', 'Question', 'Marks', 'Option A', 'Option B', 'Option C', 'Option D', 'Correct Option'];

        $callback = function () use ($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            fputcsv($file, ['10', 'Science', 'What is the chemical symbol for water?', '1', 'H2O', 'CO2', 'O2', 'NaCl', 'A']);
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
