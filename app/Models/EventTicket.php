<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventTicket extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'event_id',
        'name_guest',
        'name_guest_arabic',
        'guest_category',
        'guest_category_arabic',
        'access_permitted',
        'access_permitted_arabic',

        'total_ticket',
        'remaining_ticket',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function history()
    {
        return $this->hasMany(EventTicketHistory::class);
    }
}
