<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_cach extends Model
{
    use HasFactory;
    protected $fillable=[

        "value",
        "userId",
        "status"
    ];
}
