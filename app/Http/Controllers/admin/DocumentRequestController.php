<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Resident; // Assuming your model is named Resident
use Illuminate\Http\Request;

class DocumentRequestController extends Controller
{
    public function index()
    {
        $residents = Resident::all(); 
        return view('admin.documents.index', compact('residents'));
    }

    public function create($id)
    {
        $resident = Resident::findOrFail($id);
        return view('admin.documents.create', compact('resident'));
    }
}
