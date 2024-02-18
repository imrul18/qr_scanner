<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventTicket;
use Illuminate\Http\Request;

class ScanController extends Controller
{
    public function scannerPage()
    {
        $events = Event::where('status', 1)->get();
        return view('pages.scanner.index', compact('events'));
    }

    public function ticketScan(Request $request)
    {
        $content = $request->content;
        if (strlen($content) < 1) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid QR Code!',
            ]);
        }

        if (strpos($content, 'event/ticket')) {
            $url = explode('/', $content);
            $url = end($url);
            if (!$url) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid QR Code!',
                ]);
            } else {
                $ticket = EventTicket::query();
                if ($request->has('event_id')) {
                    $ticket = $ticket->where('event_id', $request->event_id);
                }
                $ticket = $ticket->where('uuid', $url)->first();
                if (!$ticket) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Ticket Not Found!',
                    ]);
                }

                if ($ticket->remaining_ticket < 1) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Ticket Limit Reached!',
                    ]);
                }

                $ticket->remaining_ticket = $ticket->remaining_ticket - 1;
                $ticket->save();
                $ticket->history()->create();
                return response()->json([
                    'status' => 'success',
                    'message' => 'Ticket Scanned Successfully!',
                ]);
            }
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid QR Code!',
            ]);
        }
    }
}
