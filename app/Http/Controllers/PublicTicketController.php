<?php

namespace App\Http\Controllers;

use App\Models\EventTicket;
use App\Services\GooglePassService;
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
        $ticket = EventTicket::with('event')->where('uuid', $request->uuid)->first();
        $event = $ticket->event;

        //Collect from Google
        $issuerId = 3388000000022201265;
        $keyFile = public_path('key.json');

        //Initiate the service
        $service = new GooglePassService($keyFile, 3388000000022201265);

        //Create class as event
        $organizerName = $event->name;
        $classId = $service->createClass($event->id, $event->name, $organizerName);

        $description = $event->description ?? $event->name;

        $heroImage = 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRkZFfXe8EsJYiYzFOm9jCakTaEitpwrzAbPurTAYwVog&s';
        $mainImage = 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR70RnqeZDZHL6ruAMUnHWr_0-JOXchWaHDICEnGARoSw&s';
        $objectId = $service->createObject($classId, $ticket->uuid . 'test1', $event->name, $description, $heroImage, $mainImage, $ticket->name, $ticket->uuid);

        return redirect($service->createLink($classId, $objectId));
    }
}
