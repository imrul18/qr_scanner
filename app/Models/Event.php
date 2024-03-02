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

        'header_1',
        'header_2',
        'header_3',

        'venue_name_1',
        'venue_name_2',
        'venue_location',
        'venue_lat',
        'venue_lon',

        'partner_logo',
        'aminity_logo',

        'access_details_1',
        'access_details_2',

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
