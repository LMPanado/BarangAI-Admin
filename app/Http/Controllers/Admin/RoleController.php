<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AuditLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RoleController extends Controller
{
    /**
     * Display a listing of users with search functionality.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $sort   = $request->input('sort', 'latest');

        $query = User::where('id', '!=', auth()->id())
            ->when($search, function ($q) use ($search) {
                $q->where(function ($q2) use ($search) {
                    $q2->where('first_name', 'ilike', "%{$search}%")
                       ->orWhere('last_name',  'ilike', "%{$search}%")
                       ->orWhere('email',       'ilike', "%{$search}%");
                });
            });

        $query = match($sort) {
            'az'    => $query->orderBy('last_name')->orderBy('first_name'),
            'role'  => $query->orderBy('role', 'desc'),
            default => $query->orderByDesc('created_at'),
        };

        $users = $query->paginate(10)->withQueryString();

        return view('admin.roles.index', compact('users', 'sort'));
    }

    /**
     * Update the specified user's role in the database.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:0,2,3',
        ]);

        $newRole = (int) $request->role;

        // Explicitly assign and save to force the SQL UPDATE
        // (using update() can skip the query if Eloquent thinks nothing changed)
        $user->role     = $newRole;
        $user->is_admin = in_array($newRole, [2, 3]);
        $user->saveQuietly(); // bypass observer so Resident sync doesn't run on a role-only change

        // Confirm the value persisted by reading fresh from DB
        $user->refresh();

        AuditLogger::log('role_changed', 'User',
            ($user->last_name ?? $user->name) . ' → ' . $this->getRoleLabel($user->role),
            $user->id
        );

        return back()->with('success', "Role for {$user->first_name} {$user->last_name} has been updated to " . $this->getRoleLabel($user->role));
    }

    public function resetPassword(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user->password = Hash::make($request->password);
        $user->saveQuietly();

        AuditLogger::log('updated', 'User',
            'Password reset for ' . ($user->last_name ?? '') . ', ' . ($user->first_name ?? ''),
            $user->id
        );

        return back()->with('success', "Password for {$user->first_name} {$user->last_name} has been reset successfully.");
    }

    private function getRoleLabel($role)
    {
        return match((int)$role) {
            2 => 'Barangay Captain',
            3 => 'Barangay Staff',
            default => 'Resident',
        };
    }
}