<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\AuditLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Show the login form.
     * Fixes the "Undefined method showAdminLogin" error.
     */
    public function showAdminLogin()
    {
        // Ensure this blade file exists at resources/views/auth/login.blade.php
        return view('auth.login'); 
    }

    /**
     * Handle the login request.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        try {
            $authenticated = Auth::attempt($credentials);
        } catch (\RuntimeException $e) {
            // Resident accounts from the mobile app may use a non-Bcrypt hash
            return back()->with('error', 'This portal is for barangay admin accounts only. Residents must use the mobile app.');
        }

        if ($authenticated) {
            $user = Auth::user();

            // Role check: 1=Admin, 2=Captain, 3=Official
            if (in_array((int)$user->role, [1, 2, 3])) {
                $request->session()->regenerate();
                AuditLogger::log('login', 'User', $user->last_name . ', ' . $user->first_name, $user->id);
                return redirect()->intended(route('dashboard'));
            }

            // If the user role is not staff (e.g., a Resident)
            Auth::logout();
            return back()->with('error', 'This portal is for barangay admin accounts only. Residents must use the mobile app.');
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    /**
     * Handle the logout request.
     */
    public function logout(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            AuditLogger::log('logout', 'User', $user->last_name . ', ' . $user->first_name, $user->id);
        }
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}