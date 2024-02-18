<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Event;
use App\Models\EventTicket;

use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Imagick;
use ImagickDraw;

use Chiiya\LaravelPasses\PassBuilder;
use Illuminate\Support\Facades\Storage;

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
            'date' => 'required',
            'venue' => 'required',
        ]);
        $data = $request->only(['name', 'name_arabic', 'date', 'date_arabic', 'venue', 'venue_arabic']);
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/event', $fileName);
            $data['logo'] = $fileName;
        }
        if ($request->hasFile('logo_arabic')) {
            $file = $request->file('logo_arabic');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/event', $fileName);
            $data['logo_arabic'] = $fileName;
        }


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
        $ticket = EventTicket::with(['event', 'history'])->find($id);


        $data = url('/event/ticket/' . $ticket->uuid);
        $renderer = new ImageRenderer(
            new RendererStyle(200),
            new ImagickImageBackEnd()
        );
        $writer = new Writer($renderer);
        $qrCodeImage = $writer->writeString($data);
        $qr = new Imagick();
        $draw = new ImagickDraw();
        $qr->readImageBlob($qrCodeImage);
        $textMetrics = $qr->queryFontMetrics($draw, $ticket->uuid);
        $textWidth = $textMetrics['textWidth'];
        $qr->annotateImage($draw, 100 - ($textWidth / 2), 195, 0, $ticket->uuid);
        $qrCode = $qr->getImageBlob();

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
                'name_guest' => $row[1],
                'name_guest_arabic' => $row[2],
                'guest_category' => $row[3],
                'guest_category_arabic' => $row[4],
                'access_permitted' => $row[5],

                'total_ticket' => $row[5],
                'remaining_ticket' => $row[5],
            ]);
        }
        fclose($file);

        return redirect()->back()->with('success', 'Ticket uploaded successfully!');
    }

    public function ExportQrCode($id)
    {
        $event = Event::find($id);
        $tickets = $event->tickets;
        $zip = new \ZipArchive();
        $zipFileName = 'qrcode_' . $event->name . '.zip';
        if ($zip->open($zipFileName, \ZipArchive::CREATE) === TRUE) {
            foreach ($tickets as $ticket) {
                $data = url('/event/ticket/' . $ticket->uuid);
                $renderer = new ImageRenderer(
                    new RendererStyle(200),
                    new ImagickImageBackEnd()
                );
                $writer = new Writer($renderer);
                $qrCodeImage = $writer->writeString($data);
                $qr = new Imagick();
                $draw = new ImagickDraw();
                $qr->readImageBlob($qrCodeImage);
                $textMetrics = $qr->queryFontMetrics($draw, $ticket->uuid);
                $textWidth = $textMetrics['textWidth'];
                $qr->annotateImage($draw, 100 - ($textWidth / 2), 195, 0, $ticket->uuid);
                $qrCode = $qr->getImageBlob();
                $fileName = $ticket->uuid . '.png';
                Storage::disk('local')->put('public/qrcode/' . $fileName, $qrCode);
                $zip->addFile(storage_path('app/public/qrcode/' . $fileName), $fileName);
            }
            $zip->close();
        }
        return response()->download($zipFileName)->deleteFileAfterSend(true);
    }
}
