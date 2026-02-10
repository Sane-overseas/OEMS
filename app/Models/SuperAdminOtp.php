<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuperAdminOtp extends Model
{
      protected $fillable = [
        'super_admin_id',
        'otp',
        'expires_at'
    ];

    protected $casts = [
        'expires_at' => 'datetime'
    ];
}
