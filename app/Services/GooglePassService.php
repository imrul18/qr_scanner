<?php

namespace App\Services;

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

class GooglePassService
{
    /**
     * Service account credentials for Google Wallet APIs.
     */
    public ServiceAccountCredentials $credentials;

    public Google_Client $client;

    /**
     * Google Wallet service client.
     */
    public Google_Service_Walletobjects $service;

    public function __construct(public string $keyFilePath, public int $issuerId)
    {
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
            $this->keyFilePath
        );

        // Initialize Google Wallet API service
        $this->client = new Google_Client();
        $this->client->setApplicationName(config('app.name'));
        $this->client->setScopes($scope);
        $this->client->setAuthConfig($this->keyFilePath);

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
    public function createClass(string $classSuffix, string $eventName, string $issuerName = '')
    {
        // Check if the class exists
        try {
            $this->service->eventticketclass->get("{$this->issuerId}.{$classSuffix}");

            return "{$this->issuerId}.{$classSuffix}";
        } catch (\Google\Service\Exception $ex) {
            //
        }

        // See link below for more information on required properties
        // https://developers.google.com/wallet/tickets/events/rest/v1/eventticketclass
        $newClass = new Google_Service_Walletobjects_EventTicketClass([
            'eventId' => "{$this->issuerId}.{$classSuffix}",
            'eventName' => new Google_Service_Walletobjects_LocalizedString([
                'defaultValue' => new Google_Service_Walletobjects_TranslatedString([
                    'language' => 'en-US',
                    'value' => $eventName
                ])
            ]),
            'id' => "{$this->issuerId}.{$classSuffix}",
            'issuerName' => $issuerName,
            'reviewStatus' => 'UNDER_REVIEW'
        ]);

        $response = $this->service->eventticketclass->insert($newClass);

        return $response->id;
    }

    public function createObject(string $classId, string $objectSuffix, string $vanue, string $eventName, string $qrCode, string $eventDescription, string $ticketHolder, string|int $ticketNumber, $heroImage, string $location)
    {
        try {
            $object = $this->service->eventticketobject->get("{$this->issuerId}.{$objectSuffix}");

            if ($object) {
                return $object->id;
            }
        } catch (\Google\Service\Exception $ex) {
            //
        }

        $newObject = new Google_Service_Walletobjects_EventTicketObject([
            'id' => "{$this->issuerId}.{$objectSuffix}",
            'classId' => $classId,
            'state' => 'ACTIVE',
            'heroImage' => new Google_Service_Walletobjects_Image([
                'sourceUri' => new Google_Service_Walletobjects_ImageUri([
                    'uri' => $heroImage
                ]),
                'contentDescription' => new Google_Service_Walletobjects_LocalizedString([
                    'defaultValue' => new Google_Service_Walletobjects_TranslatedString([
                        'language' => 'en-US',
                        'value' => "{$eventName} Hero Image"
                    ])
                ])
            ]),
            'textModulesData' => [
                new Google_Service_Walletobjects_TextModuleData([
                    'header' => $eventName,
                    'body' => $eventDescription,
                    'id' => 'TEXT_MODULE_ID'
                ])
            ],
            'linksModuleData' => new Google_Service_Walletobjects_LinksModuleData([
                'uris' => [
                    new Google_Service_Walletobjects_Uri([
                        'uri' => $location,
                        'description' => 'Link module URI description',
                        'id' => 'LINK_MODULE_URI_ID'
                    ]),
                    // new Google_Service_Walletobjects_Uri([
                    //     'uri' => 'tel:6505555555',
                    //     'description' => 'Link module tel description',
                    //     'id' => 'LINK_MODULE_TEL_ID'
                    // ])
                ]
            ]),
            'imageModulesData' => [
                new Google_Service_Walletobjects_ImageModuleData([
                    'mainImage' => new Google_Service_Walletobjects_Image([
                        'sourceUri' => new Google_Service_Walletobjects_ImageUri([
                            'uri' => $heroImage
                        ]),
                        'contentDescription' => new Google_Service_Walletobjects_LocalizedString([
                            'defaultValue' => new Google_Service_Walletobjects_TranslatedString([
                                'language' => 'en-US',
                                'value' => "{$eventName} Main Image"
                            ])
                        ])
                    ]),
                    'id' => 'IMAGE_MODULE_ID'
                ])
            ],
            'barcode' => new Google_Service_Walletobjects_Barcode([
                'type' => 'QR_CODE',
                'value' => $qrCode
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
            //             'value' => "{$eventName} Background Image"
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
                        'value' => $vanue
                    ])
                ])
            ]),
            'ticketHolderName' => $ticketHolder,
            'ticketNumber' => $ticketNumber,

        ]);

        $response = $this->service->eventticketobject->insert($newObject);

        return $response->id;
    }

    public function createLink($classId, $objectId)
    {
        // The service account credentials are used to sign the JWT
        $serviceAccount = json_decode(file_get_contents($this->keyFilePath), true);

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
