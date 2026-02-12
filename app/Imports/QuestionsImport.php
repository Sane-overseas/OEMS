<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Question;
use App\Models\QuestionOption;
use Illuminate\Support\Facades\Auth;    
class QuestionsImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function sheets(): array
    {
        return [
            0 => $this, // first sheet
            1 => $this, // second sheet
            2 => $this, // third sheet
            // you can add more if you want
        ];
    }
    public function collection(Collection $rows)
    {
        $admin = Auth::guard('admin')->user();

        foreach ($rows as $row) {

            if (
                empty($row['class']) ||
                empty($row['subject']) ||
                empty($row['question'])
            ) {
                continue;
            }

            $question = Question::create([
                'school_id' => $admin->school_id,
                'class'     => trim($row['class']),
                'subject'   => trim($row['subject']),
                'question'  => trim($row['question']),
                'marks'     => (int) $row['marks'],
                'type'      => 'mcq'
            ]);

            $options = [
                'A' => $row['option_a'] ?? null,
                'B' => $row['option_b'] ?? null,
                'C' => $row['option_c'] ?? null,
                'D' => $row['option_d'] ?? null,
            ];

            $correct = strtoupper(trim($row['correct_option'] ?? ''));

            foreach ($options as $key => $text) {

                if (!$text) continue;

                QuestionOption::create([
                    'question_id' => $question->id,
                    'option_text' => trim($text),
                    'is_correct'  => ($key === $correct),
                ]);
            }
        }
    }
}
