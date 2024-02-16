<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventTicket;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function eventList(Request $request)
    {
        $events = Event::query();
        if ($request->has('search')) {
            $events = $events->where('name', 'like', '%' . $request->search . '%');
        }
        $events = $events->paginate('10');
        return view('pages.events.list', compact('events'));
    }

    public function eventAddPage()
    {
        return view('pages.events.add');
    }

    public function eventAdd(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
        ]);
        $data = $request->only(['name']);
        $event = Event::create($data);
        if ($event) {
            return redirect()->route('event-list-page')->with('success', 'Event added successfully!');
        }
        return redirect()->back()->with('error', 'Something wents wrong!')->withInput();
    }

    public function eventEditPage($id)
    {
        $event = Event::find($id);
        return view('pages.events.edit', compact('event'));
    }

    public function eventEdit(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|min:3',
            'status' => 'required',
        ]);
        $data = $request->only(['name', 'status']);

        $event = Event::find($id)->update($data);
        if ($event) {
            return redirect()->route('event-list-page')->with('success', 'Event update successfully!');
        }
        return redirect()->back()->with('error', 'Something wents wrong!')->withInput();
    }

    public function eventDelete($id)
    {
        $event = Event::find($id)->delete();
        if (!$event) {
            return redirect()->back()->with('error', 'Something wents wrong!');
        }
        return redirect()->route('event-list-page')->with('success', 'Event delete successfully!');
    }

    public function eventViewPage(Request $request, $id)
    {
        $event = Event::with('tickets')->find($id);

        $tickets = $event->tickets();
        if ($request->has('search')) {
            $tickets = $tickets->where('uuid', 'like', '%' . $request->search . '%');
        }
        $tickets = $tickets->paginate('10');

        return view('pages.events.view', compact('event', 'tickets'));
    }

    public function eventTicketViewPage($id)
    {
        $ticket = EventTicket::with('history')->find($id);

        $data = url('/event/ticket/' . $ticket->uuid);
        $renderer = new ImageRenderer(
            new RendererStyle(200),
            new ImagickImageBackEnd()
        );
        $writer = new Writer($renderer);
        $qrCode = $writer->writeString($data);

        return view('pages.events.ticket_view', compact('ticket', 'qrCode'));
    }

    public function TicketUpload(Request $request, $id)
    {
        $request->validate([
            'tickets_file' => 'required|file|mimes:csv|max:2048',
        ]);
        $file = $request->file('tickets_file');
        $event = Event::find($id);

        $file = fopen($file, 'r');
        $header = fgetcsv($file);
        while ($row = fgetcsv($file)) {
            $event->tickets()->create([
                'uuid' => strtoupper(uniqid()),
                'name' => $row[0],
                'price' => $row[1],
                'total_ticket' => $row[2],
                'remaining_ticket' => $row[2],
                'status' => 1,
            ]);
        }
        fclose($file);

        return redirect()->back()->with('success', 'Ticket uploaded successfully!');
    }

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
}
