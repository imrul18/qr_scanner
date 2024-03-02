<?php

namespace App\Services;

use App\Models\EventTicket;
use Illuminate\Support\Facades\Storage;
use PKPass\PKPass;

class ApplePassService
{

    public $data = [], $pass;

    public function __construct()
    {
        $this->pass = new PKPass(public_path('Certificates.p12'), '123456');
        $this->data = [
            'formatVersion' => 1,
            'organizationName' => 'Test Company',
            'passTypeIdentifier' => 'pass.event.ticket.demo',
            'teamIdentifier' => 'JQ6475PC63',
        ];
    }

    /**
     * Create a pass.
     *
     * @param string $passTypeIdentifier Pass type identifier for the pass.
     * @param string $serialNumber Unique serial number for the pass.
     * @param string $teamIdentifier Team identifier associated with your Apple Developer account.
     * @param array $data Data for creating the pass.
     * @param string $certificatePath Path to the certificate file.
     * @param string $certificatePassword Password for the certificate file.
     *
     * @return string Path to the created pass file.
     */
    public function createPass($ticket_id)
    {
        $ticket = EventTicket::with('event')->find($ticket_id);
        $event = $ticket->event;

        $data = [
            ...$this->data,
            'description' => $event->header_1,
            'serialNumber' => $ticket->uuid,
            'eventTicket' => [
                'primaryFields' => [
                    [
                        'key' => 'event',
                        'label' => 'EVENT',
                        'value' => $event->name,
                    ],
                    [
                        'key' => 'location',
                        'label' => 'VENUE',
                        'value' => $event->venue_name_1,
                    ],
                ],
                'secondaryFields' => [
                    [
                        'key' => 'date',
                        'label' => 'DATE',
                        'value' => date('Y-m-d', strtotime($event->date)),
                    ],
                    [
                        'key' => 'time',
                        'label' => 'TIME',
                        'value' => date('H:i A', strtotime($event->date)),
                    ],
                ],
                'auxiliaryFields' => [
                    [
                        'key' => 'section',
                        'label' => 'VENUE',
                        'value' => $event->venue_name_1
                    ],
                ],
                'backFields' => [
                    [
                        'key' => 'ticket',
                        'label' => 'TICKET',
                        'value' => $ticket->uuid,
                    ],
                ],
            ],


            'barcode' => [
                'format' => 'PKBarcodeFormatQR',
                'message' => url('/event/ticket/' . $ticket->uuid),
                'messageEncoding' => 'iso-8859-1',
            ],

            'foregroundColor' => $event->font_color,
            'relevantDate' => date('Y-m-d\TH:i:sP'),

        ];
        $this->pass->setData($data);

        info(public_path('images/icon.png'));
        info(public_path('images/logo.png'));
        info(storage_path('app/' . $event->partner_logo));
        info(Storage::path($event->partner_logo));

        $this->pass->addFile(public_path('images/icon.png'));
        $this->pass->addFile(public_path('images/thumbnail.png'));
        $this->pass->addFile(public_path('images/logo.png'));
        $this->pass->addFile(public_path('images/background.png'));
        // $this->pass->addFile(storage_path('app/'.$event->logo));
        // $this->pass->addFile(Storage::path($event->bg_image));
        // $this->pass->addFile(Storage::path($event->partner_logo));

        return $this->pass->create(true);
    }
}
