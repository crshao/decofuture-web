<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function user() //belongs only to user with role seller
    {
        return $this->belongsTo(User::class);
    }
}
