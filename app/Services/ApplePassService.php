<?php

namespace App\Services;

use PKPass\PKPass;

class ApplePassService
{
    public function __construct()
    {
        //
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
    public function createPass(string $passTypeIdentifier, string $serialNumber, string $teamIdentifier, array $data, string $certificatePath, string $certificatePassword, string $vanue, string $eventName, $date, $venueLocation, $eventLogo, $qrCode)
    {
        $pass = new PKPass(public_path('Certificates.p12'), '123456');
        $data = [
            'description' => 'Demo pass',
            'formatVersion' => 1,
            'organizationName' => 'Test Company',
            'passTypeIdentifier' => 'pass.event.ticket.demo', // Change this!
            'serialNumber' => $serialNumber,
            'teamIdentifier' => 'JQ6475PC63', // Change this!



            'eventTicket' => [
                'primaryFields' => [
                    [
                        'key' => 'event',
                        'label' => 'EVENT',
                        'value' => $eventName,
                    ],
                    [
                        'key' => 'location',
                        'label' => 'LOCATION',
                        'value' => $venueLocation,
                    ],
                ],
                'secondaryFields' => [
                    [
                        'key' => 'date',
                        'label' => 'DATE',
                        'value' => date('Y-m-d', strtotime($date)),
                    ],
                    [
                        'key' => 'time',
                        'label' => 'TIME',
                        'value' => date('H:i A', strtotime($date)),
                    ],
                ],
                'auxiliaryFields' => [
                    [
                        'key' => 'section',
                        'label' => 'VENUE',
                        'value' => $vanue
                    ],
                ],
                'backFields' => [
                    [
                        'key' => 'ticket',
                        'label' => 'TICKET',
                        'value' => $serialNumber,
                    ],
                ],

                'headerFields' => [
                    [
                        'key' => 'logo',
                        'label' => 'Logo',
                        'value' => $eventLogo,
                        'url' => $eventLogo,
                        'file' => $eventLogo
                    ]
                ],
            ],


            'barcode' => [
                'format' => 'PKBarcodeFormatQR',
                'message' => $qrCode,
                'messageEncoding' => 'iso-8859-1',
            ],

            'backgroundImage' => base64_encode(file_get_contents($eventLogo)),

            'backgroundColor' => 'rgb(255,0,0)', // Change this!
            'foregroundColor' => 'rgb(0,0,0)',
            'relevantDate' => date('Y-m-d\TH:i:sP'),

        ];
        $pass->setData($data);


        $pass->addFile(public_path('images/icon.png'));
        $pass->addFile(public_path('images/avatars/2.png'));
        $pass->addFile(public_path('images/avatars/3.png'));
        return $pass->create(true);

        // Create a pass using PassFactory
        $pass = $this->passFactory->createPass($passTypeIdentifier, $serialNumber, $teamIdentifier, $data);

        // Sign the pass using PassSigner
        $this->passSigner->setCertificate($certificatePath, $certificatePassword);
        $this->passSigner->sign($pass);

        // Define the path to save the pass file
        $passFilePath = "/path/to/save/{$passTypeIdentifier}_{$serialNumber}.pkpass";

        // Write the pass to a file
        file_put_contents($passFilePath, $pass->get());

        return $passFilePath;
    }
}
