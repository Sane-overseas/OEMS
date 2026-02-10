<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
     protected $fillable = [
        'school_id','grade','subject','question','marks'
    ];

    public function options()
    {
        return $this->hasMany(QuestionOption::class);
    }
}
