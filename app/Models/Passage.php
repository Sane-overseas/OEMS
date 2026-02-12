<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Passage extends Model
{
    protected $fillable = [
        'school_id',
        'class',
        'subject',
        'title',
        'content'
    ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
