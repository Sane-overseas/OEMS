<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SecurityLog extends Model
{
    protected $fillable = [
        'guard',
        'user_id',
        'event',
        'ip_address',
        'user_agent',
        'description',
        'payload',
    ];

    protected $casts = [
        'payload' => 'array',
    ];
}
