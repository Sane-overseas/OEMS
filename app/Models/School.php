<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     * Using guarded instead of fillable to protect the primary key only.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    /**
     * Get the admins associated with the school.
     */
    public function admins()
    {
        return $this->hasMany(Admin::class);
    }
}
