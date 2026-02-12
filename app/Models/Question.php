<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
     protected $fillable = [
        'school_id','class','subject','question_text','marks'
    ];

    public function options()
    {
        return $this->hasMany(QuestionOption::class);
    }
}
