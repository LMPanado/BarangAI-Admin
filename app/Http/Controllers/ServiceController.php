<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function show($type)
    {
        $services = [
            'barangay-id' => [
                'title' => 'Barangay I.D.',
                'description' => 'The official identification card for residents of Barangay 419, now manageable via our mobile platform.',
                'uses' => ['Proof of Residency', 'Valid Gov Identification', 'Local Employment', 'Banking Requirements'],
                'requirements' => ['Digital copy of Government ID', 'Proof of Address (Utility Bill)', 'Digital Cedula', 'P50.00 Digital Payment'],
                'steps_new' => [
                    'Open the Barangay 419 Mobile App and navigate to "Request Document".',
                    'Select "Barangay ID" and upload clear photos of your requirements.',
                    'Take a selfie through the app\'s secure photo-capture interface.',
                    'Pay the processing fee via the integrated GCash or Maya gateway.',
                    'Receive an app notification when your ID is ready for pick-up.'
                ],
                'steps_renewal' => [
                    'Select "Renew ID" in the mobile app.',
                    'Confirm if your current address and information remain the same.',
                    'Upload a photo of your expired ID.',
                    'Pay the renewal fee through the app.',
                    'Wait for the digital confirmation to claim your new physical card.'
                ]
            ],
            'business-permit' => [
                'title' => 'Business Permit',
                'description' => 'A mandatory requirement for all business entities, streamlined through digital application.',
                'uses' => ['Legal Business Operation', 'Mayor\'s Permit Requirement', 'Opening Business Bank Accounts'],
                'requirements' => ['Government-Issued ID', 'Proof of Address (e.g Utility Bill, Lease Agreement)', 'Digital Cedula', 'Supporting documents specific to the certificate type'],
                'steps_new' => [
                    'Select "Request Document" on the mobile app dashboard.',
                    'Select "Apply for New or Renewal Permit" and fill in your business details.',
                    'Upload the required documents through the app\'',
                    'Submit your application and track its status in real-time through the app.',
                    'When ready for pick-up, you will receive a notification to claim your digital certificate and physical sticker at the barangay hall.'
                ],
                'steps_renewal' => [
                    'Find your existing permit record in the app\'s "My Documents" section.',
                    'Select "Apply for Renewal" and input your Gross Sales declaration.',
                    'Upload the previous year\'s digital permit copy.',
                    'Pay the renewal fees instantly via mobile payment.',
                    'Receive your updated digital certificate and sticker via the app.'
                ]
            ],
            'cedula' => [
                'title' => 'Cedula (Community Tax)',
                'description' => 'Fast-track your Community Tax Certificate through our automated mobile assessment.',
                'uses' => ['Notarization of Documents', 'Applying for Marriage License', 'Birth Certificate Registration', 'Employment'],
                'requirements' => ['Valid ID Photo', 'Income Declaration (Self-declared via app)'],
                'steps_new' => [
                    'Tap the "Cedula" icon on the mobile app home screen.',
                    'Enter your personal details (Height, Weight, and Profession).',
                    'Input your annual gross earnings for automatic tax calculation.',
                    'Affix your digital signature on the screen.',
                    'Pay via the app and receive a QR code to print your Cedula at the Barangay Kiosk.'
                ],
                'steps_renewal' => [
                    'The app will notify you every January for renewal.',
                    'Select "Annual Renewal" to use your saved profile information.',
                    'Update your income for the new year.',
                    'Pay the calculated tax through the app.',
                    'Instantly access your updated Digital Cedula.'
                ]
            ],
            'barangay-clearance' => [
                'title' => 'Barangay Clearance',
                'description' => 'Secure your clearance for employment or legal needs without waiting in line.',
                'uses' => ['Employment Application', 'Police Clearance Requirement', 'Postal ID Application', 'Passport Application'],
                'requirements' => ['Selfie for Identity Verification', 'App-generated Cedula', 'Purpose of Request'],
                'steps_new' => [
                    'Go to the "Clearance" section in the Barangay 419 App.',
                    'Select the purpose of your clearance (e.g., Employment, Passport).',
                    'The app will automatically link your existing digital Cedula.',
                    'Pay the standard clearance fee via mobile wallet.',
                    'Wait for the digital "Verified" status and claim your embossed copy at the express window.'
                ],
                'steps_renewal' => [
                    'Select "Request New Copy" from your document history.',
                    'Verify if your purpose has changed.',
                    'Settle the standard fee through the mobile payment gateway.',
                    'Your new clearance will be processed and ready for pick-up in minutes.'
                ]
            ]
        ];

        if (!isset($services[$type])) {
            abort(404);
        }

        return view('client.services.show', ['service' => $services[$type]]);
    }
}