<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Temperature extends Model
{
    use HasFactory;

    //needs to be filled in with the fields that are allowed to be mass assigned as they are used elsewhere
    protected $fillable = [
        'heaterOn',
        'windowOpen',
        'acOn',
    ];
}
