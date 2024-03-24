<?php

namespace App\Services;

use App\Models\EventTicket;
use App\Models\MasterSetting;
use Illuminate\Support\Facades\Storage;
use PKPass\PKPass;

class ApplePassService
{

    public $data = [], $pass;

    public function __construct()
    {
        $setting = MasterSetting::get();
        $this->pass = new PKPass(base_path('/public_html/' . $setting->where('key', 'certificatePath')->first()->value), $setting->where('key', 'certificatePassword')->first()->value);
        // $this->pass = new PKPass(public_path() . '/' . $setting->where('key', 'certificatePath')->first()->value, $setting->where('key', 'certificatePassword')->first()->value);
        $this->pass->addFile(base_path('/public_html/' . $setting->where('key', 'appleWalletIcon')->first()->value));
        // $this->pass->addFile(public_path() . '/' . $setting->where('key', 'appleWalletIcon')->first()->value);
        $this->data = [
            'formatVersion' => 1,
            'organizationName' => $setting->where('key', 'organizationName')->first()->value,
            'passTypeIdentifier' => $setting->where('key', 'passTypeIdentifier')->first()->value,
            'teamIdentifier' => $setting->where('key', 'teamIdentifier')->first()->value,
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
            'description' => $event->name,
            'serialNumber' => $ticket->uuid,
            'eventTicket' => [
                'headerFields' => [
                    [
                        'key' => 'date',
                        'label' => 'Date',
                        'value' => date('Y-m-d H:i A', strtotime($event->date)),
                    ],
                ],
                'primaryFields' => [
                    [
                        'key' => 'event-name',
                        'label' => '',
                        'value' => $event->name,
                    ],
                ],
                'secondaryFields' => [
                    [
                        'key' => 'header',
                        'label' => '',
                        'value' => $event->header_1,
                    ]
                ],
                'auxiliaryFields' => [
                    [
                        'key' => 'section',
                        'label' => '',
                        'value' => $event->venue_name_1,
                    ],
                    [
                        'key' => 'section2',
                        'label' => '',
                        'value' => $event->venue_name_2 ?? "",
                    ],
                ],
                'backFields' => [
                    [
                        'key' => 'ticket',
                        'label' => 'TICKET',
                        'value' => $ticket->uuid,
                    ],
                    [
                        'key' => 'locations',
                        'label' => 'LOCATION',
                        'value' => $event->venue_location,
                    ]
                ],

                'locations' => [
                    [
                        'latitude' => $event->venue_lat,
                        'longitude' => $event->venue_lon,
                    ]
                ],
            ],


            'barcode' => [
                'format' => 'PKBarcodeFormatQR',
                'message' => url('/event/ticket/' . $ticket->uuid),
                'messageEncoding' => 'iso-8859-1',
            ],


            'backgroundColor' => $event->background_color,
            'foregroundColor' => $event->wallet_font_color,
            'labelColor' => $event->wallet_font_color,
            'relevantDate' => date('Y-m-d\TH:i:sP', strtotime($event->date)),

        ];
        $this->pass->setData($data);

        $this->pass->addFile(base_path('/public_html/' . $event->wallet_logo));
        // $this->pass->addFile(public_path() . '/' . $event->wallet_logo);
        $this->pass->addFile(base_path('/public_html/' . $event->wallet_partner_logo));
        // $this->pass->addFile(public_path() . '/' . $event->wallet_partner_logo);


        return $this->pass->create(true);
    }
}
