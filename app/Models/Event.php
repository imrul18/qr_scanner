<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'name_arabic',
        'date',
        'date_arabic',
        'venue',
        'venue_arabic',
        'logo',
        'logo_arabic',
        'status',
    ];

    public function tickets()
    {
        return $this->hasMany(EventTicket::class);
    }
}
