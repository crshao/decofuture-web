<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class master_transactions extends Model
{
    use HasFactory;
    //deserialize arrat from json to php array
    protected $casts = [
        'address' => 'array'
    ];
}
