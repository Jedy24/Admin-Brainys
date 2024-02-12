<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserBrainys extends Model
{
    protected $table = 'user-brainys';

    protected $fillable = [
        'name',
        'email',
        'profession',
        'school_name',
        'created_at',
        'updated_at'
    ];
}
