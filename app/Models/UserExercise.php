<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserExercise extends Model
{
    protected $table = 'user_exercise';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'user_name',
        'user_id',
    ];
}
