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
        'name',
        'price',
        'total_ticket',
        'remaining_ticket',
        'status'
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
