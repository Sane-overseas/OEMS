<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StaffRequest extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'school_id',
        'requester_id',
        'name',
        'email',
        'mobile',
        'photo',
        'staff_type',
        'professional_details',
        'role',
        'password',
        'aadhaar_name',
        'aadhaar_number',
        'aadhaar_dob',
        'aadhaar_gender',
        'status',
        'rejection_reason',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'professional_details' => 'array',
        'approved_at' => 'datetime',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function requester()
    {
        return $this->belongsTo(Admin::class, 'requester_id');
    }
}
