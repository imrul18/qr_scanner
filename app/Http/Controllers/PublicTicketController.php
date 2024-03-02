<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventTicket;
use App\Services\ApplePassService;
use App\Services\GooglePassService;
use Illuminate\Http\Request;

use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Imagick;
use ImagickDraw;

class PublicTicketController extends Controller
{
    public function showTicket($uuid)
    {
        $ticket = EventTicket::with('event')->where('uuid', $uuid)->first();

        if (!$ticket) {
            $error = 'Invalid ticket!';
            return view('pages.events.show_ticket', compact('error'));
        }

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


        if (!auth()->check()) {
            $fontFamily = $ticket->event->font_family;
            $fontColor = $ticket->event->font_color;
            $bgImage = $ticket->event->bg_image;
            return view('pages.events.show_ticket', compact('ticket', 'qrCode', 'fontFamily', 'fontColor', 'bgImage'));
        } else {
            return redirect()->route('scanner-page', 'uuid=' . $ticket->uuid);
        }
    }

    public function addToWallet(Request $request)
    {
        $method = $request->method;
        $ticket = EventTicket::with('event')->where('uuid', $request->uuid)->first();

        if (!$ticket) {
            return response()->json(['error' => 'Invalid ticket!'], 404);
        }

        if ($method == 'apple') {
            return $this->addToAppleWallet($ticket->id);
        } elseif ($method == 'google') {
            return $this->addToGoogleWallet($ticket->id, $ticket->event);
        } else {
            return response()->json(['error' => 'Invalid method!'], 400);
        }
    }

    public function addToGoogleWallet(EventTicket $ticket, Event $event)
    {
        $issuerId = 3388000000022318351;
        // $keyFile = storage_path(/app/public/key)
        $keyFile = public_path('key.json');

        $service = new GooglePassService($keyFile, $issuerId);

        $organizerName = $event->name;
        $classId = $service->createClass($event->id, $event->name, $organizerName);

        $description = $event->header_1;

        $qrCode = url('/event/ticket/' . $ticket->uuid);
        $heroimage = asset('storage/event/' . $event->logo);
        // TODO - Add a default image if the event logo is not available
        $heroimage = "https://buffer.com/library/content/images/size/w1200/2023/10/free-images.jpg";

        $objectId = $service->createObject($classId, $ticket->uuid, $event->venue_name_1, $event->name, $qrCode, $description, $ticket->guest_name, $ticket->uuid, $heroimage, $event->venue_location);

        return redirect($service->createLink($classId, $objectId));
    }

    public function  addToAppleWallet($ticket_id)
    {
        $service = new ApplePassService();
        $passFilePath = $service->createPass($ticket_id);

        return response()->download($passFilePath, 'ticket_pass.pkpass')->deleteFileAfterSend();
    }
}
