<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'requester_id',
        'target_user_id',
        'request_type',
        'reason',
        'status',
        'rejection_reason',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function requester()
    {
        return $this->belongsTo(Admin::class, 'requester_id');
    }

    public function targetUser()
    {
        return $this->belongsTo(Admin::class, 'target_user_id');
    }
}