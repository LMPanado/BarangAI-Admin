<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AuditLogger;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of users with search functionality.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $users = User::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
        })
        // We exclude the logged-in Admin so they don't accidentally demote themselves
        ->where('id', '!=', auth()->id())
        ->paginate(10);

        return view('admin.roles.index', compact('users'));
    }

    /**
     * Update the specified user's role in the database.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:0,2,3',
        ]);

        // Update the role and the is_admin flag automatically
        // is_admin is true for Captain (2) and Official (3), false for Resident (0)
        $user->update([
            'role' => $request->role,
            'is_admin' => in_array($request->role, [2, 3])
        ]);

        AuditLogger::log('role_changed', 'User',
            ($user->last_name ?? $user->name) . ' → ' . $this->getRoleLabel($request->role),
            $user->id
        );

        return back()->with('success', "Role for {$user->name} has been updated to " . $this->getRoleLabel($request->role));
    }

    private function getRoleLabel($role)
    {
        return match((int)$role) {
            2 => 'Barangay Captain',
            3 => 'Barangay Official',
            default => 'Resident',
        };
    }
}