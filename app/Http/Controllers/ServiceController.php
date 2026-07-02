<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function show($type)
    {
        $commonSteps = function (string $documentName) {
            return [
                'Download the BarangAI Mobile Application from the link below.',
                'Open the Barangay 419 Mobile App and navigate to Quick Access or Services, then tap "Request Document".',
                'Select "' . $documentName . '" from the list of available documents.',
                'Enter your personal information and purpose of request.',
                'Submit your application and wait for barangay staff to review it.',
                'Receive an app notification when your document is ready for pick-up at the barangay hall.',
            ];
        };

        $services = [
            'barangay-id' => [
                'title' => 'Barangay I.D.',
                'description' => 'The official identification card for residents of Barangay 419, now manageable via our mobile platform.',
                'uses' => ['Proof of Residency', 'Valid Gov Identification', 'Local Employment', 'Banking Requirements'],
                'requirements' => ['Digital copy of Government ID', 'Proof of Address (Utility Bill)', 'Digital Cedula'],
                'steps_new' => $commonSteps('Barangay I.D.'),
            ],
            'business-permit' => [
                'title' => 'Business Permit',
                'description' => 'A mandatory requirement for all business entities, streamlined through digital application.',
                'uses' => ['Legal Business Operation', 'Mayor\'s Permit Requirement', 'Opening Business Bank Accounts'],
                'requirements' => ['Government-Issued ID', 'Proof of Address (e.g Utility Bill, Lease Agreement)', 'Supporting documents specific to the certificate type'],
                'steps_new' => $commonSteps('Business Permit'),
            ],
            'barangay-clearance' => [
                'title' => 'Barangay Clearance',
                'description' => 'Secure your clearance for employment or legal needs without waiting in line.',
                'uses' => ['Employment Application', 'Police Clearance Requirement', 'Postal ID Application', 'Passport Application'],
                'requirements' => ['Valid Government-Issued ID', 'Purpose of Request'],
                'steps_new' => $commonSteps('Barangay Clearance'),
            ],
            'certificate-of-indigency' => [
                'title' => 'Certificate of Indigency',
                'description' => 'An official document certifying that a resident belongs to an indigent or low-income household, used to access government assistance and social services.',
                'uses' => ['Social Welfare Assistance', 'PhilHealth / 4Ps Application', 'Medical and Hospital Fee Discount', 'Scholarship Application', 'Free Legal Aid'],
                'requirements' => ['Valid Government-Issued ID', 'Proof of Residency (Utility Bill or Lease)', 'Purpose of Request'],
                'steps_new' => $commonSteps('Certificate of Indigency'),
            ],
        ];

        if (!isset($services[$type])) {
            abort(404);
        }

        return view('client.services.show', ['service' => $services[$type]]);
    }
}