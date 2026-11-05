<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class admin extends Model
{
    //
    protected $fillable = [
        'pic_url',
        'pic_forward',
        'right_id',
        'left_id',
        'back_id',
    ];
}
