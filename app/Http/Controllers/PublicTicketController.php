<?php

namespace App\Http\Controllers;

use App\Models\EventTicket;
use Illuminate\Http\Request;

class PublicTicketController extends Controller
{
    public function showTicket($uuid)
    {
        $ticket = EventTicket::where('uuid', $uuid)->first();
        if (!$ticket) {
            $error = 'Invalid ticket!';
            return view('pages.events.show_ticket', compact('error'));
        }
        if (!auth()->check()) {
            return view('pages.events.show_ticket', compact('ticket'));
        } else {
            return redirect()->route('scanner-page', 'uuid=' . $ticket->uuid);
        }
    }

    public function addToWallet(Request $request)
    {
        $uuid = $request->uuid;
        $method = $request->method;

        return $method;
    }
}
