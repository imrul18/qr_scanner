<?php

namespace App\Http\Controllers;

use App\Models\EventTicket;
use Illuminate\Http\Request;

class ScanController extends Controller
{
    public function scannerPage()
    {
        return view('pages.scanner.index');
    }

    public function ticketDetails($uuid)
    {
        $ticket = EventTicket::where('uuid', $uuid)->first();
        if (!$ticket) {
            $ticket->status = 'error';
            $ticket->message = 'Ticket not found!';
        } else {
            $ticket->status = 'success';
        }
        return response()->json($ticket);
    }

    public function ticketScan(Request $request)
    {
        $request->validate([
            'uuid' => 'required|exists:event_tickets,uuid'
        ]);
        $ticket = EventTicket::where('uuid', $request->uuid)->first();
        $ticket->remaining_ticket = $ticket->remaining_ticket - 1;
        $ticket->save();
        $ticket->history()->create();
        return redirect()->route('scanner-page')->with('success', 'Ticket checked in successfully!');
    }
}
