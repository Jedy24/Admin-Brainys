<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserBrainys extends Model
{
    protected $table = 'user-brainys';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
        'email',
        'profession',
        'school_name',
    ];
}
