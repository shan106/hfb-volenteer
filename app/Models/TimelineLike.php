<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimelineLike extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'timeline_post_id',
    ];
}
