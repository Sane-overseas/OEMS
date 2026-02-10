<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Database\Eloquent\Model;

class SuperAdmin extends Authenticatable
{
     protected $fillable = [
        'name','email','password','is_active'
    ];

    protected $hidden = [
        'password',
    ];
}
