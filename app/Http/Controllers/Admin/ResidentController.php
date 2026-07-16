<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Resident;
use App\Models\User;
use App\Services\AuditLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResidentController extends Controller
{
    public function index(Request $request)
    {
        $query = Resident::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'ilike', "%{$search}%")
                  ->orWhere('last_name', 'ilike', "%{$search}%")
                  ->orWhere('email', 'ilike', "%{$search}%")
                  ->orWhereRaw("CAST(id AS TEXT) LIKE ?", ["%{$search}%"]);
            });
        }

        $sort = $request->get('sort', 'latest');
        match ($sort) {
            'az'     => $query->orderBy('last_name')->orderBy('first_name'),
            'id'     => $query->orderBy('id'),
            default  => $query->latest(),
        };

        $residents = $query->paginate(10)->withQueryString();
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
            'height_cm'    => 'nullable|numeric|min:0',
            'weight_kg'    => 'nullable|numeric|min:0',
            'address'      => 'required|string',
        ]);

        $id = DB::table('residents')->insertGetId(array_merge(
            $validated,
            [
                'is_voter'   => DB::raw('false'),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ));
        $resident = Resident::find($id);

        AuditLogger::log('created', 'Resident', $resident->last_name . ', ' . $resident->first_name, $resident->id);

        return redirect()->route('admin.residents.index')->with('success', 'Added resident successfully!');
    }

    public function edit(Resident $resident)
    {
        // If linked to a user account, pull latest data from users table
        // so the form always reflects the most recent mobile app changes
        $children = [];
        if ($resident->user_id) {
            $user = User::find($resident->user_id);
            if ($user) {
                $resident->fill([
                    'first_name'   => $user->first_name,
                    'middle_name'  => $user->middle_name,
                    'last_name'    => $user->last_name,
                    'email'        => $user->email,
                    'phone'        => $user->phone,
                    'age'          => $user->age,
                    'gender'       => $user->gender,
                    'civil_status' => $user->civil_status,
                    'address'      => $user->address,
                    'is_voter'     => $user->is_voter ?? false,
                    'birth_date'   => $user->birth_date,
                    'place_birth'  => $user->place_birth,
                    'height_cm'    => $user->height_cm,
                    'weight_kg'    => $user->weight_kg,
                ]);
                $children = $user->children ?? [];
            }
        }

        return view('admin.residents.edit', compact('resident', 'children'));
    }

    public function update(Request $request, Resident $resident)
    {
        $validated = $request->validate([
            'first_name'      => 'required|string|max:255',
            'last_name'       => 'required|string|max:255',
            'middle_name'     => 'nullable|string|max:255',
            'email'           => 'required|email|unique:residents,email,' . $resident->id,
            'phone'           => 'nullable|string|max:20',
            'age'             => 'required|integer|min:0',
            'gender'          => 'required|string',
            'civil_status'    => 'nullable|string',
            'birth_date'      => 'nullable|date',
            'place_birth'     => 'nullable|string|max:255',
            'height_cm'       => 'nullable|numeric|min:0',
            'weight_kg'       => 'nullable|numeric|min:0',
            'is_voter'        => 'required|boolean',
            'address'         => 'required|string',
            'children_groups' => 'nullable|array',
            'children_groups.*' => 'in:0-2,3-5,6-12',
        ]);

        $isVoter = !empty($validated['is_voter']);

        // Use DB::table directly so boolean is_voter is cast correctly for PostgreSQL
        DB::table('residents')->where('id', $resident->id)->update(array_merge(
            array_diff_key($validated, ['is_voter' => '']),
            [
                'is_voter'   => DB::raw($isVoter ? 'true' : 'false'),
                'updated_at' => now(),
            ]
        ));

        // Build children JSONB array
        $childrenJson = '[]';
        $civilStatus = $validated['civil_status'] ?? null;
        if (in_array($civilStatus, ['Married', 'Widowed', 'Separated'])) {
            $groups = $request->input('children_groups', []);
            $childrenArr = array_map(fn($g) => ['age_group' => $g], $groups);
            $childrenJson = json_encode($childrenArr);
        }

        // Sync back to the linked user account if one exists
        if ($resident->user_id) {
            DB::table('users')->where('id', $resident->user_id)->update([
                'first_name'   => $validated['first_name'],
                'last_name'    => $validated['last_name'],
                'middle_name'  => $validated['middle_name'] ?? null,
                'email'        => $validated['email'],
                'phone'        => $validated['phone'] ?? null,
                'age'          => $validated['age'],
                'gender'       => $validated['gender'],
                'civil_status' => $civilStatus,
                'address'      => $validated['address'],
                'is_voter'     => DB::raw($isVoter ? 'true' : 'false'),
                'birth_date'   => $validated['birth_date'] ?? null,
                'place_birth'  => $validated['place_birth'] ?? null,
                'height_cm'    => $validated['height_cm'] ?? null,
                'weight_kg'    => $validated['weight_kg'] ?? null,
                'children'     => DB::raw("'{$childrenJson}'::jsonb"),
                'updated_at'   => now(),
            ]);
        }

        AuditLogger::log('updated', 'Resident', $resident->last_name . ', ' . $resident->first_name, $resident->id);

        return redirect()->route('admin.residents.edit', $resident->id)->with('success', 'Resident updated successfully!');
    }

    public function destroy(Resident $resident)
    {
        AuditLogger::log('deleted', 'Resident', $resident->last_name . ', ' . $resident->first_name, $resident->id);
        $resident->delete();
        return redirect()->route('admin.residents.index')->with('success', 'Resident deleted successfully!');
    }

    public function printList()
    {
        $residents = Resident::orderBy('last_name')->orderBy('first_name')->get();

        AuditLogger::log('printed', 'Resident', 'Resident list sent to print');

        return view('admin.residents.print', compact('residents'));
    }
}