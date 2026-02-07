<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Resident; 
use Illuminate\Http\Request;

class ResidentController extends Controller
{
    public function index()
    {
        $residents = Resident::latest()->paginate(10);
        return view('admin.residents.index', compact('residents'));
    }

    public function create()
    {
        return view('admin.residents.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name'   => 'required|string|max:255',
            'last_name'    => 'required|string|max:255',
            'middle_name'  => 'nullable|string|max:255',
            'email'        => 'required|email|unique:residents,email', 
            'phone'        => 'nullable|string|max:20',
            'age'          => 'required|integer|min:0',
            'gender'       => 'required|string',
            'civil_status' => 'nullable|string',
            'birth_date'   => 'nullable|date',
            'place_birth'  => 'nullable|string|max:255',
            'height_cm'    => 'nullable|integer|min:0',
            'weight_kg'    => 'nullable|integer|min:0',
            'is_voter'     => 'required|boolean',
            'address'      => 'required|string',
        ]);

        Resident::create($validated);

        return redirect()->route('admin.residents.index')->with('success', 'Added resident successfully!');
    }

    public function edit(Resident $resident)
    {
        return view('admin.residents.edit', compact('resident'));
    }

    public function update(Request $request, Resident $resident)
    {
        $validated = $request->validate([
            'first_name'   => 'required|string|max:255',
            'last_name'    => 'required|string|max:255',
            'middle_name'  => 'nullable|string|max:255',
            'email'        => 'required|email|unique:residents,email,' . $resident->id,
            'phone'        => 'nullable|string|max:20',
            'age'          => 'required|integer|min:0',
            'gender'       => 'required|string',
            'civil_status' => 'nullable|string',
            'birth_date'   => 'nullable|date',
            'place_birth'  => 'nullable|string|max:255',
            'height_cm'    => 'nullable|integer|min:0',
            'weight_kg'    => 'nullable|integer|min:0',
            'is_voter'     => 'required|boolean',
            'address'      => 'required|string',
        ]);

        $resident->update($validated);

        return redirect()->route('admin.residents.index')->with('success', 'Resident updated successfully!');
    }

    public function destroy(Resident $resident)
    {
        $resident->delete();
        return redirect()->route('admin.residents.index')->with('success', 'Resident deleted successfully!');
    }
}