<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSyllabus extends Model
{
    protected $table = 'user_syllabus';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'user_name',
        'user_id',
    ];
}
