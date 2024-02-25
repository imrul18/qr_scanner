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
        $event = $ticket->event;

        if (!$ticket) {
            return response()->json(['error' => 'Invalid ticket!'], 404);
        }

        if ($method == 'apple') {
            return $this->addToAppleWallet($ticket, $event);
        } elseif ($method == 'google') {
            return $this->addToGoogleWallet($ticket, $event);
        } else {
            return response()->json(['error' => 'Invalid method!'], 400);
        }
    }

    public function addToGoogleWallet(EventTicket $ticket, Event $event)
    {
        $issuerId = 3388000000022318351;
        $keyFile = public_path('key.json');

        $service = new GooglePassService($keyFile, $issuerId);
        $organizerName = $event->name;
        $classId = $service->createClass($event->id, $event->name, $organizerName);

        $description = $event->description ?? $event->name;

        $heroImage = 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRkZFfXe8EsJYiYzFOm9jCakTaEitpwrzAbPurTAYwVog&s';
        $mainImage = 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR70RnqeZDZHL6ruAMUnHWr_0-JOXchWaHDICEnGARoSw&s';
        $objectId = $service->createObject($classId, $ticket->uuid . 'test1', $event->name, $description, $heroImage, $mainImage, $ticket->name_guest, $ticket->uuid);

        return redirect($service->createLink($classId, $objectId));
    }

    public function  addToAppleWallet(EventTicket $ticket, Event $event)
    {
        $passTypeIdentifier = 'your.pass.type.identifier';
        $teamIdentifier = 'your.team.identifier';
        $certificatePath = 'path/to/certificate.p12';
        $certificatePassword = 'certificate_password';

        $service = new ApplePassService();

        // Define pass data
        $passData = [
            'event_name' => $event->name,
            'description' => $event->description ?? $event->name,
            'ticket_holder' => $ticket->name_guest,
            // Add any other relevant data for the pass
        ];

        // Create the pass
        $passFilePath = $service->createPass(
            $passTypeIdentifier,
            $ticket->uuid,
            $teamIdentifier,
            $passData,
            $certificatePath,
            $certificatePassword
        );

        return response()->download($passFilePath, 'ticket_pass.pkpass')->deleteFileAfterSend();
    }
}
