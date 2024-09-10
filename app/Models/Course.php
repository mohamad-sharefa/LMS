<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $fillable=[

        "name",
        "section_id",
        'user_id',
        'image',
        "description",
        "price",

        "status"

    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
