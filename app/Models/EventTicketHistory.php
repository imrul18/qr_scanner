<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventTicketHistory extends Model
{
    use HasFactory;

    protected $fillable = ['event_ticket_id'];
}
