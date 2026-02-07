<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guard = 'admin';

    protected $fillable = [
        'school_id',
        'name',
        'email',
        'mobile',
        'password',
        'role',
        'photo',
        'staff_type',
        'professional_details',
        'status',
        'aadhaar_number',
        'aadhaar_name',
        'aadhaar_dob',
        'aadhaar_gender',
        'login_method',
        'two_factor',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
        'two_factor' => 'boolean',
        'professional_details' => 'array',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
