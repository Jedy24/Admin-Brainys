<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserMaterial extends Model
{
    protected $table = 'user_material';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'user_name',
        'user_id',
    ];
}
