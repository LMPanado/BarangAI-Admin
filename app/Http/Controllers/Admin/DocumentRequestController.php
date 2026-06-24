<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Resident;
use App\Models\DocumentRequest;
use App\Services\AuditLogger;
use Illuminate\Http\Request;

class DocumentRequestController extends Controller
{
    /**
     * Display current requests submitted by residents.
     * This is the "Document Requests" page.
     */
    public function index(Request $request)
    {
        // Start query with resident details to avoid N+1 issues
        $query = DocumentRequest::with('resident');

        // Handle search functionality for the new search bar
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('purpose', 'like', "%{$search}%")
                  ->orWhere('document_type', 'like', "%{$search}%")
                  ->orWhereHas('resident', function($qr) use ($search) {
                      $qr->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%");
                  });
            });
        }

        $sort = $request->get('sort', 'latest');

        match ($sort) {
            'oldest'   => $query->oldest(),
            'status'   => $query->orderByRaw("CASE status WHEN 'pending' THEN 1 WHEN 'processing' THEN 2 WHEN 'ready_for_pickup' THEN 3 WHEN 'completed' THEN 4 ELSE 5 END"),
            'document' => $query->orderBy('document_type'),
            default    => $query->latest(),
        };

        if ($request->filled('status_filter')) {
            $query->where('status', $request->status_filter);
        }

        $allRequests    = $query->get();
        $mobileRequests = $allRequests->filter(fn($r) => $r->source === 'mobile' || ($r->source !== 'kiosk'));
        $kioskRequests  = $allRequests->filter(fn($r) => $r->source === 'kiosk');
        $requests       = $allRequests;

        return view('admin.documents.index', compact('requests', 'mobileRequests', 'kioskRequests', 'sort'));
    }

    /**
     * Handles generating the actual certificate.
     * Renamed from 'create' to 'issuance' as per your requirement.
     */
    public function issuance($id)
    {
        // Find the specific request by its ID and include resident data
        $request = DocumentRequest::with('resident')->findOrFail($id);
        
        return view('admin.documents.issuance', compact('request'));
    }

    /**
     * Updates the status of the request (e.g., Pending -> Ready for Pickup)
     */
    public function updateStatus(Request $request, $id)
    {
        $docRequest = DocumentRequest::findOrFail($id);
        $docRequest->update(['status' => $request->status]);

        $residentName = optional($docRequest->resident)->last_name . ', ' . optional($docRequest->resident)->first_name;
        AuditLogger::log('status_changed', 'DocumentRequest',
            $docRequest->document_type . ' for ' . $residentName . ' → ' . $request->status,
            $docRequest->id
        );

        return redirect()->back()->with('success', 'Status updated!');
    }
    /**
     * Verify a kiosk request and generate a reference number.
     */
    public function verify($id)
    {
        $docRequest = DocumentRequest::findOrFail($id);

        $refNo = 'REF-' . now()->format('Ymd') . '-' . str_pad($docRequest->id, 4, '0', STR_PAD_LEFT);
        $docRequest->update(['reference_no' => $refNo]);

        AuditLogger::log('updated', 'DocumentRequest',
            'Kiosk request #' . $docRequest->id . ' verified → ' . $refNo,
            $docRequest->id
        );

        return redirect()->back()->with('success', 'Request verified. Reference number generated: ' . $refNo);
    }

    public function destroy($id)
    {
        $docRequest = DocumentRequest::with('resident')->findOrFail($id);
        $residentName = optional($docRequest->resident)->last_name . ', ' . optional($docRequest->resident)->first_name;
        AuditLogger::log('deleted', 'DocumentRequest', $docRequest->document_type . ' for ' . $residentName, $docRequest->id);
        $docRequest->delete();

        return redirect()->route('admin.documents.index')
            ->with('success', 'Document request deleted successfully.');
    }
}