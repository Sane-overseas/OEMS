<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = [
        'school_id',
        'title',
        'class',
        'subject',
        'total_marks',
        'duration_minutes',
        'instructions',
        'status',
        'created_by'
    ];

    public function questions()
    {
        return $this->belongsToMany(
            Question::class,
            'exam_question'
        )->withPivot('marks')->withTimestamps();
    }

    public function schedule()
    {
        return $this->hasOne(ExamSchedule::class);
    }
}
