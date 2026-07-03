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

        try {
            // Use query builder directly to avoid pgBouncer prepared-statement issues
            \DB::table('users')->where('id', $user->id)->update([
                'role'       => $newRole,
                'is_admin'   => \DB::raw(in_array($newRole, [2, 3]) ? 'true' : 'false'),
                'updated_at' => now(),
            ]);

            try {
                AuditLogger::log('role_changed', 'User',
                    ($user->last_name ?? $user->name) . ' → ' . $this->getRoleLabel($newRole),
                    $user->id
                );
            } catch (\Exception $e) {
                \Log::warning('AuditLogger failed on role_changed: ' . $e->getMessage());
            }

            $name = trim("{$user->first_name} {$user->last_name}");
            return redirect()->route('admin.roles.index')
                ->with('success', "Role for {$name} has been updated to " . $this->getRoleLabel($newRole));

        } catch (\Exception $e) {
            \Log::error('Role update failed: ' . $e->getMessage());
            return redirect()->route('admin.roles.index')
                ->with('error', 'Failed to update role. Please try again.');
        }
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