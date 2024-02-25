<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'logo',
        'name',
        'date',
        'venue',

        'header',
        'partner_logo',
        'aminity_logo',
        'entry_message',
        'venue_location',

        'bg_image',
        'font_family',
        'font_color',

        'status',
    ];

    public function tickets()
    {
        return $this->hasMany(EventTicket::class);
    }
}
