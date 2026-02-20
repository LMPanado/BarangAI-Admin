<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\DocumentRequest;
use App\Models\Resident; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $events = Schedule::orderBy('schedule_date', 'asc')->take(6)->get();
        return view('client.index', compact('events'));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('client.profile', compact('user'));
    }

    public function requests()
    {
        $resident = Resident::where('user_id', Auth::id())->first();

        $requests = DocumentRequest::where('resident_id', $resident->id ?? 0)
                    ->orderBy('created_at', 'desc')
                    ->get();

        return view('client.requests', compact('requests'));
    }

    public function requestDocument()
    {
        return view('client.request');
    }

    public function storeDocumentRequest(Request $request)
    {
        $request->validate([
            'document_type' => 'required|string',
            'purpose' => 'required|string|max:500',
            'pickup_date' => 'required|date|after_or_equal:today',
        ]);

        // 1. Try to find resident by user_id
        $resident = Resident::where('user_id', Auth::id())->first();

        // 2. If not found (because user_id is NULL), try to find by Email
        if (!$resident) {
            $resident = Resident::where('email', Auth::user()->email)->first();
            
            // 3. If we found them by email, link them now so it's not NULL anymore
            if ($resident) {
                $resident->update(['user_id' => Auth::id()]);
            }
        }

        // 4. Final check: if still no resident, we can't proceed
        if (!$resident) {
            return back()->withErrors([
                'error' => 'Your account is not linked to a Resident profile. Please ensure your email ' . Auth::user()->email . ' matches your Resident record.'
            ])->withInput();
        }

        // 5. Create the request using the now-linked resident_id
        DocumentRequest::create([
            'resident_id' => $resident->id, 
            'document_type' => $request->document_type,
            'purpose' => $request->purpose,
            'pickup_date' => $request->pickup_date,
            'status' => 'pending',
        ]);

        return redirect()->route('client.requests')->with('success', 'Document request submitted successfully!');
    }
}