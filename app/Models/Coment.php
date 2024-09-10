<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coment extends Model
{
    use HasFactory;
    protected $fillable=[

        "value",
        "course_id",
        "user_id",
        "parentId",
        "video_id"
    ];



    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // إذا كان لديك علاقة أخرى مثل 'replies'


    public function replies()
    {






        return $this->hasMany(Coment::class, 'parentId');
    }



    public function course()
    {
        return $this->belongsTo(Course::class);
    }



    public function parent()
    {
        return $this->belongsTo(Coment::class, 'parentId');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($comment) {
            // Delete all replies
            $comment->replies()->delete();
        });
    }
}
