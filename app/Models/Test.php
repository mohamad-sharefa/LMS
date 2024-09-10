<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;
    protected $fillable=[


        "name",
        "description",
        "user_id",
        "course_id",
        "video_id",
    ];
}
