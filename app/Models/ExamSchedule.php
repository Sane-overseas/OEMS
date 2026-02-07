<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamSchedule extends Model
{
    protected $fillable = [
        'exam_id',
        'start_at',
        'end_at'
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }
}
