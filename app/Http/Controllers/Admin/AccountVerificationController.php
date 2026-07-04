<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Resident;
use App\Models\User;
use App\Services\AuditLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountVerificationController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', User::ROLE_RESIDENT)
            ->where('verification_status', 'pending')
            ->orderByDesc('verification_submitted_at');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('first_name', 'ilike', "%{$s}%")
                  ->orWhere('last_name',  'ilike', "%{$s}%")
                  ->orWhere('email',      'ilike', "%{$s}%");
            });
        }

        $pendingUsers = $query->paginate(10)->withQueryString();

        $pendingCount = User::where('role', User::ROLE_RESIDENT)
            ->where('verification_status', 'pending')
            ->count();

        return view('admin.verification.index', compact('pendingUsers', 'pendingCount'));
    }

    public function verify($id)
    {
        $user = User::findOrFail($id);

        // Use query builder to avoid pgBouncer boolean casting issues
        DB::table('users')->where('id', $user->id)->update([
            'verification_status' => 'verified',
            'updated_at'          => now(),
        ]);

        $isVoter = $user->is_voter ? 'true' : 'false';

        // Check if resident record already exists
        $existing = DB::table('residents')->where('user_id', $user->id)->first();

        $residentData = [
            'first_name'   => $user->first_name,
            'middle_name'  => $user->middle_name,
            'last_name'    => $user->last_name,
            'suffix'       => $user->suffix,
            'email'        => $user->email,
            'phone'        => $user->phone,
            'age'          => $user->age,
            'gender'       => $user->gender,
            'civil_status' => $user->civil_status,
            'address'      => $user->address,
            'is_voter'     => DB::raw($isVoter),
            'birth_date'   => $user->birth_date,
            'place_birth'  => $user->place_birth,
            'height_cm'    => $user->height_cm,
            'weight_kg'    => $user->weight_kg,
            'updated_at'   => now(),
        ];

        if ($existing) {
            DB::table('residents')->where('user_id', $user->id)->update($residentData);
        } else {
            DB::table('residents')->insert(array_merge($residentData, [
                'user_id'    => $user->id,
                'created_at' => now(),
            ]));
        }

        try {
            AuditLogger::log(
                'status_changed',
                'User',
                $user->last_name . ', ' . $user->first_name . ' → Verified',
                $user->id
            );
        } catch (\Exception $e) {
            \Log::warning('AuditLogger failed on verify: ' . $e->getMessage());
        }

        return response()->json(['success' => true, 'status' => 'verified']);
    }

    public function reject(Request $request, $id)
    {
        $request->validate(['rejection_reason' => 'required|string|max:500']);

        $user = User::findOrFail($id);
        $user->update([
            'verification_status' => 'rejected',
            'rejection_reason'    => $request->rejection_reason,
        ]);

        AuditLogger::log(
            'status_changed',
            'User',
            $user->last_name . ', ' . $user->first_name . ' → Rejected',
            $user->id
        );

        return response()->json(['success' => true, 'status' => 'rejected']);
    }
}
