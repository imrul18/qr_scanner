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
        'guest_name',
        'guest_category',
        'total_access_permitted',
        'children_access_permitted',
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
