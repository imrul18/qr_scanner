<?php

namespace App\Services;

use App\Models\Event;
use App\Models\EventTicket;
use App\Models\MasterSetting;
use Firebase\JWT\JWT;
use Google\Auth\Credentials\ServiceAccountCredentials;
use Google_Client;
use Google_Service_Walletobjects;
use Google_Service_Walletobjects_Barcode;
use Google_Service_Walletobjects_EventSeat;
use Google_Service_Walletobjects_EventTicketClass;
use Google_Service_Walletobjects_EventTicketObject;
use Google_Service_Walletobjects_Image;
use Google_Service_Walletobjects_ImageModuleData;
use Google_Service_Walletobjects_ImageUri;
use Google_Service_Walletobjects_LatLongPoint;
use Google_Service_Walletobjects_LinksModuleData;
use Google_Service_Walletobjects_LocalizedString;
use Google_Service_Walletobjects_TextModuleData;
use Google_Service_Walletobjects_TranslatedString;
use Google_Service_Walletobjects_Uri;
use Illuminate\Support\Facades\Storage;

class GooglePassService
{
    /**
     * Service account credentials for Google Wallet APIs.
     */
    public ServiceAccountCredentials $credentials;

    public Google_Client $client;

    public string $keyFilePath, $issuerId, $organizationName;
    public EventTicket $ticket;
    public Event $event;

    /**
     * Google Wallet service client.
     */
    public Google_Service_Walletobjects $service;

    public function __construct($ticket_id)
    {
        $this->ticket = EventTicket::with('event')->find($ticket_id);
        $this->event = $this->ticket->event;
        $setting = MasterSetting::get();
        $this->keyFilePath = $setting->where('key', 'keyFilePath')->first()->value;
        $this->issuerId = $setting->where('key', 'issuerId')->first()->value;
        $this->organizationName = $setting->where('key', 'organizationName')->first()->value;
        $this->auth();
    }

    /**
     * Create authenticated HTTP client using a service account file.
     */
    public function auth()
    {
        $scope = 'https://www.googleapis.com/auth/wallet_object.issuer';

        $this->credentials = new ServiceAccountCredentials(
            $scope,
            Storage::path($this->keyFilePath)
        );

        // Initialize Google Wallet API service
        $this->client = new Google_Client();
        $this->client->setApplicationName(config('app.name'));
        $this->client->setScopes($scope);
        $this->client->setAuthConfig(Storage::path($this->keyFilePath));

        $this->service = new Google_Service_Walletobjects($this->client);
    }

    /**
     * Create a class.
     *
     * @param string $classSuffix Developer-defined unique ID for this pass class.
     * @param string $eventName Event name of the ticket
     * @param string $issuerName Issuer name of the event
     *
     * @return string The pass class ID: "{$issuerId}.{$classSuffix}"
     */
    public function createClass()
    {
        // Check if the class exists
        try {
            $this->service->eventticketclass->get("{$this->issuerId}.{$this->event->id}");

            return "{$this->issuerId}.{$this->event->id}";
        } catch (\Google\Service\Exception $ex) {
            //
        }

        // See link below for more information on required properties
        // https://developers.google.com/wallet/tickets/events/rest/v1/eventticketclass
        $newClass = new Google_Service_Walletobjects_EventTicketClass([
            'eventId' => "{$this->issuerId}.{$this->event->id}",
            'eventName' => new Google_Service_Walletobjects_LocalizedString([
                'defaultValue' => new Google_Service_Walletobjects_TranslatedString([
                    'language' => 'en-US',
                    'value' => $this->event->name
                ])
            ]),
            'id' => "{$this->issuerId}.{$this->event->id}",
            'issuerName' => $this->organizationName,
            'reviewStatus' => 'UNDER_REVIEW'
        ]);

        $response = $this->service->eventticketclass->insert($newClass);

        return $response->id;
    }

    public function createObject(string $classId)
    {
        try {
            $object = $this->service->eventticketobject->get("{$this->issuerId}.{$this->ticket->uuid}");

            if ($object) {
                return $object->id;
            }
        } catch (\Google\Service\Exception $ex) {
            //
        }

        $newObject = new Google_Service_Walletobjects_EventTicketObject([
            'id' => "{$this->issuerId}.{$this->ticket->uuid}",
            'classId' => $classId,
            'state' => 'ACTIVE',
            'heroImage' => new Google_Service_Walletobjects_Image([
                'sourceUri' => new Google_Service_Walletobjects_ImageUri([
                    'uri' => Storage::url($this->event->partner_logo)
                ]),
                'contentDescription' => new Google_Service_Walletobjects_LocalizedString([
                    'defaultValue' => new Google_Service_Walletobjects_TranslatedString([
                        'language' => 'en-US',
                        'value' => "{$this->event->name} Hero Image"
                    ])
                ])
            ]),
            'textModulesData' => [
                new Google_Service_Walletobjects_TextModuleData([
                    'header' => $this->event->name,
                    'body' => $this->event->header_1,
                    'id' => 'TEXT_MODULE_ID'
                ])
            ],
            'linksModuleData' => new Google_Service_Walletobjects_LinksModuleData([
                'uris' => [
                    new Google_Service_Walletobjects_Uri([
                        'uri' => $this->event->venue_location,
                        'description' => 'Link module URI description',
                        'id' => 'LINK_MODULE_URI_ID'
                    ]),
                ]
            ]),
            'barcode' => new Google_Service_Walletobjects_Barcode([
                'type' => 'QR_CODE',
                'value' => url('/event/ticket/' . $this->ticket->uuid)
            ]),
            'locations' => [
                new Google_Service_Walletobjects_LatLongPoint([
                    'latitude' => 37.424015499999996,
                    'longitude' =>  -122.09259560000001
                ])
            ],
            // 'backgroundImage' => new Google_Service_Walletobjects_Image([
            //     'sourceUri' => new Google_Service_Walletobjects_ImageUri([
            //         'uri' => $heroImage
            //     ]),
            //     'contentDescription' => new Google_Service_Walletobjects_LocalizedString([
            //         'defaultValue' => new Google_Service_Walletobjects_TranslatedString([
            //             'language' => 'en-US',
            //             'value' => "{$this->event->name} Background Image"
            //         ])
            //     ])
            // ]),
            'seatInfo' => new Google_Service_Walletobjects_EventSeat([
                // 'seat' => new Google_Service_Walletobjects_LocalizedString([
                //     'defaultValue' => new Google_Service_Walletobjects_TranslatedString([
                //         'language' => 'en-US',
                //         'value' => '42'
                //     ])
                // ]),
                // 'row' => new Google_Service_Walletobjects_LocalizedString([
                //     'defaultValue' => new Google_Service_Walletobjects_TranslatedString([
                //         'language' => 'en-US',
                //         'value' => 'G3'
                //     ])
                // ]),
                'section' => new Google_Service_Walletobjects_LocalizedString([
                    'defaultValue' => new Google_Service_Walletobjects_TranslatedString([
                        'language' => 'en-US',
                        'value' => $this->event->venue_name_1
                    ])
                ])
            ]),
            'ticketHolderName' => $this->ticket->guest_name,
            'ticketNumber' => $this->ticket->uuid,

        ]);

        $response = $this->service->eventticketobject->insert($newObject);

        return $response->id;
    }

    public function createLink($classId, $objectId)
    {
        // The service account credentials are used to sign the JWT
        $serviceAccount = json_decode(file_get_contents(Storage::path($this->keyFilePath)), true);

        // Create the JWT as an array of key/value pairs
        $claims = [
            'iss' => $serviceAccount['client_email'],
            'aud' => 'google',
            'origins' => ['www.example.com'],
            'typ' => 'savetowallet',
            'payload' => [
                'eventTicketObjects' => [
                    [
                        'id' => $objectId,
                        'classId' => $classId
                    ]
                ]
            ]
        ];

        $token = JWT::encode(
            $claims,
            $serviceAccount['private_key'],
            'RS256'
        );

        return "https://pay.google.com/gp/v/save/{$token}";
    }
}
