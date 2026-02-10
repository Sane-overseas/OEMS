<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'school_id',
        'class',
        'subject',
        'type',
        'question_text',
        'marks',
        'difficulty',
        'created_by',
        'status'
    ];

    public function options()
    {
        return $this->hasMany(QuestionOption::class);
    }
}
