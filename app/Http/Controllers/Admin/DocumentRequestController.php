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

        // Use paginate() instead of get() to support the UI's pagination links
        $requests = $query->latest()->paginate(10);
        
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
    public function destroy($id)
{
    $docRequest = DocumentRequest::findOrFail($id);
    $docRequest->delete();

    return redirect()->route('admin.documents.index')
        ->with('success', 'Document request deleted successfully.');
}
}