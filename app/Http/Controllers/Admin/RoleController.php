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

        return back()->with('success', "Role for {$user->first_name} {$user->last_name} has been updated to " . $this->getRoleLabel($request->role));
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