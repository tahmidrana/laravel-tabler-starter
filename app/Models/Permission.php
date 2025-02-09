<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'title',
        'slug',
        'controller_method',
        'is_active',
        'remarks',
    ];
}
