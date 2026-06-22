<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AuditLogger;
use Illuminate\Http\Request;

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
        $user->update(['verification_status' => 'verified']);

        AuditLogger::log(
            'status_changed',
            'User',
            $user->last_name . ', ' . $user->first_name . ' → Verified',
            $user->id
        );

        return response()->json(['success' => true, 'status' => 'verified']);
    }

    public function reject($id)
    {
        $user = User::findOrFail($id);
        $user->update(['verification_status' => 'rejected']);

        AuditLogger::log(
            'status_changed',
            'User',
            $user->last_name . ', ' . $user->first_name . ' → Rejected',
            $user->id
        );

        return response()->json(['success' => true, 'status' => 'rejected']);
    }
}
