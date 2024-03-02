<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FontStyle extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'font_family'
    ];
}
