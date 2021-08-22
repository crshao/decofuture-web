<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    use HasFactory;


    //deserialize arrat from json to php array
    protected $casts = [
        'image' => 'array',
        'ar_link' => 'array',
    ];

    public function user() //belongs only to user with role seller
    {
        return $this->belongsTo(User::class);
    }
}
