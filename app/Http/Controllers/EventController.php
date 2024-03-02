<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Event;
use App\Models\EventTicket;
use App\Services\NFCService;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Imagick;
use ImagickDraw;
use Illuminate\Support\Str;

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
            'header_1' => 'required',
            'venue_name_1' => 'required',
            'venue_location' => 'required',
            'access_details_1' => 'required',
            'logo' => 'required|file|mimes:png',
            'partner_logo' => 'required|file|mimes:png',
            'aminity_logo' => 'required|file|mimes:png',
        ]);
        $data = $request->only(['name', 'date', 'header_1', 'header_2', 'header_3', 'venue_name_1', 'venue_name_2', 'venue_location', 'access_details_1', 'access_details_2', 'font_family', 'font_color']);

        $event = Event::create($data);
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $event->logo = $file->storeAs('public/event/' . $event->id, 'thumbnail.png');
        }
        if ($request->hasFile('partner_logo')) {
            $file = $request->file('partner_logo');
            $event->partner_logo = $file->storeAs('public/event/' . $event->id, 'logo.png');
        }
        if ($request->hasFile('aminity_logo')) {
            $file = $request->file('aminity_logo');
            $event->aminity_logo = $file->storeAs('public/event/' . $event->id, 'aminity_logo.png');
        }
        if ($request->hasFile('bg_image')) {
            $file = $request->file('bg_image');
            $event->bg_image = $file->storeAs('public/event/' . $event->id, 'background.png');
        }
        $event->save();

        if ($event) {
            return redirect()->route('event-list-page')->with('success', 'Event added successfully!');
        }
        return redirect()->back()->with('error', 'Something wents wrong!')->withInput();
    }

    public function eventEditPage($id)
    {
        $event = Event::find($id);

        $data = "testing QR code";
        $renderer = new ImageRenderer(
            new RendererStyle(200),
            new ImagickImageBackEnd()
        );
        $writer = new Writer($renderer);
        $qrCodeImage = $writer->writeString($data);
        $qr = new Imagick();
        $draw = new ImagickDraw();
        $qr->readImageBlob($qrCodeImage);
        $textMetrics = $qr->queryFontMetrics($draw, Str::random(12));
        $textWidth = $textMetrics['textWidth'];
        $qr->annotateImage($draw, 100 - ($textWidth / 2), 195, 0, Str::random(12));
        $qrCode = $qr->getImageBlob();

        return view('pages.events.edit', compact('event', 'qrCode'));
    }

    public function eventEdit(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|min:3',
            'date' => 'required',
            'header_1' => 'required',
            'venue_name_1' => 'required',
            'venue_location' => 'required',
            'access_details_1' => 'required',
            'status' => 'required',
        ]);

        $event = Event::find($id);
        $data = $request->only(['name', 'date', 'header_1', 'header_2', 'header_3', 'venue_name_1', 'venue_name_2', 'venue_location', 'access_details_1', 'access_details_2', 'font_family', 'font_color', 'status']);
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            if ($event->logo && Storage::exists($event->logo)) {
                Storage::delete($event->logo);
            }
            $event->logo = $file->storeAs('public/event/' . $event->id, 'thumbnail.png');
        }
        if ($request->hasFile('partner_logo')) {
            $file = $request->file('partner_logo');
            if ($event->partner_logo && Storage::exists($event->partner_logo)) {
                Storage::delete($event->partner_logo);
            }
            $event->partner_logo = $file->storeAs('public/event/' . $event->id, 'logo.png');
        }
        if ($request->hasFile('aminity_logo')) {
            $file = $request->file('aminity_logo');
            if ($event->aminity_logo && Storage::exists($event->aminity_logo)) {
                Storage::delete($event->aminity_logo);
            }
            $event->aminity_logo = $file->storeAs('public/event/' . $event->id, 'aminity_logo.png');
        }
        if ($request->hasFile('bg_image')) {
            $file = $request->file('bg_image');
            if ($event->bg_image && Storage::exists($event->bg_image)) {
                Storage::delete($event->bg_image);
            }
            $event->bg_image = $file->storeAs('public/event/' . $event->id, 'background.png');
        }
        $event->update($data);

        if ($event) {
            return redirect()->back()->with('success', 'Event update successfully!');
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

        $data = "testing QR code";
        $renderer = new ImageRenderer(
            new RendererStyle(200),
            new ImagickImageBackEnd()
        );
        $writer = new Writer($renderer);
        $qrCodeImage = $writer->writeString($data);
        $qr = new Imagick();
        $draw = new ImagickDraw();
        $qr->readImageBlob($qrCodeImage);
        $textMetrics = $qr->queryFontMetrics($draw, Str::random(12));
        $textWidth = $textMetrics['textWidth'];
        $qr->annotateImage($draw, 100 - ($textWidth / 2), 195, 0, Str::random(12));
        $qrCode = $qr->getImageBlob();

        return view('pages.events.view', compact('event', 'tickets', 'qrCode'));
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
        $qr->readImageBlob($qrCodeImage);
        $draw = new ImagickDraw();
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
        try {
            $file = $request->file('tickets_file');
            $event = Event::find($id);

            $file = fopen($file, 'r');
            $header = fgetcsv($file);
            while ($row = fgetcsv($file)) {
                $event->tickets()->create([
                    'uuid' => strtoupper(uniqid()),
                    'guest_name' => $row[1],
                    'guest_category' => $row[2],
                    'total_access_permitted' => $row[3],
                    'children_access_permitted' => $row[4],
                    'remaining_ticket' => $row[3],
                ]);
            }
            fclose($file);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something wents wrong!');
        }
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

    public function nfcSet($id)
    {
        $serial = new NFCService();

        // Open serial connection
        $serial->deviceSet("/dev/ttyACM0");
        $serial->confBaudRate(115200);
        $serial->confParity("none");
        $serial->confCharacterLength(8);
        $serial->confStopBits(1);
        $serial->deviceOpen();

        // Main loop to read NFC tags
        while (true) {
            $tag = $serial->readPort();
            echo $tag;
        }
    }
}
