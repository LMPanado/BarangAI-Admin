<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Resident;
use App\Models\DocumentRequest;
use Illuminate\Http\Request;

class DocumentRequestController extends Controller
{
    /**
     * Display current requests submitted by residents.
     * This is the "Document Requests" page.
     */
    public function index()
    {
        // Fetch requests with resident details to avoid N+1 query issues
        $requests = DocumentRequest::with('resident')->latest()->get();
        
        return view('admin.documents.index', compact('requests'));
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

    return redirect()->back()->with('success', 'Status updated!');
}
}