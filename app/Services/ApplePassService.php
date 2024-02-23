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
    public function createPass(string $passTypeIdentifier, string $serialNumber, string $teamIdentifier, array $data, string $certificatePath, string $certificatePassword)
    {
        $pass = new PKPass(public_path('Certificates.p12'), '123456');
        $data = [
            'description' => 'Demo pass',
            'formatVersion' => 1,
            'organizationName' => 'Flight Express',
            'passTypeIdentifier' => 'pass.com.scholica.flights', // Change this!
            'serialNumber' => '12345678',
            'teamIdentifier' => 'KN44X8ZLNC', // Change this!
            'boardingPass' => [
                'primaryFields' => [
                    [
                        'key' => 'origin',
                        'label' => 'San Francisco',
                        'value' => 'SFO',
                    ],
                    [
                        'key' => 'destination',
                        'label' => 'London',
                        'value' => 'LHR',
                    ],
                ],
                'secondaryFields' => [
                    [
                        'key' => 'gate',
                        'label' => 'Gate',
                        'value' => 'F12',
                    ],
                    [
                        'key' => 'date',
                        'label' => 'Departure date',
                        'value' => '07/11/2012 10:22',
                    ],
                ],
                'backFields' => [
                    [
                        'key' => 'passenger-name',
                        'label' => 'Passenger',
                        'value' => 'John Appleseed',
                    ],
                ],
                'transitType' => 'PKTransitTypeAir',
            ],
            'barcode' => [
                'format' => 'PKBarcodeFormatQR',
                'message' => 'Flight-GateF12-ID6643679AH7B',
                'messageEncoding' => 'iso-8859-1',
            ],
            'backgroundColor' => 'rgb(32,110,247)',
            'logoText' => 'Flight info',
            'relevantDate' => date('Y-m-d\TH:i:sP')
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
