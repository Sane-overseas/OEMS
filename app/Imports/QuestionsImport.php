<?php

namespace App\Imports;

use App\Models\Question;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class QuestionsImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        $admin = auth('admin')->user();

        return new Question([
            'school_id'      => $admin->school_id,
            'class'          => $row['class'],
            'subject'        => $row['subject'],
            'type'           => 'mcq',
            'question_text'  => $row['question_text'],
            'marks'          => $row['marks'],
            'difficulty'     => strtolower($row['difficulty']),
            'option_a'       => $row['option_a'],
            'option_b'       => $row['option_b'],
            'option_c'       => $row['option_c'],
            'option_d'       => $row['option_d'],
            'correct_option' => strtoupper($row['correct_option']),
            'created_by'     => $admin->id,
            'status'         => 'active',
        ]);
    }

    public function rules(): array
    {
        return [
            'class'          => 'required',
            'subject'        => 'required',
            'question_text'  => 'required',
            'marks'          => 'required|integer',
            'difficulty'     => 'required|in:easy,medium,hard',
            'option_a'       => 'required',
            'option_b'       => 'required',
            'option_c'       => 'required',
            'option_d'       => 'required',
            'correct_option' => 'required|in:A,B,C,D',
        ];
    }
}
