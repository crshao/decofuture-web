<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product_categories extends Model
{
    use HasFactory;
    //deserialize arrat from json to php array
    protected $casts = [
        'category_url_picture' => 'array',
    ];
}
