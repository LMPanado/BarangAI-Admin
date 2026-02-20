<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    // This shows the registration page
    public function index()
    {
        return view('auth.register'); // Ensure your file is at resources/views/auth/register.blade.php
    }

    // This handles the actual saving of data
    public function store(Request $request)
    {
        // 1. Validate the resident's input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // 2. Create the resident account in the database
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Encrypts the password for security
        ]);

        // 3. Automatically log them in
        Auth::login($user);

        // 4. Send them to the home page with a success message
        return redirect('/')->with('success', 'Welcome to the Barangay 419 Portal!');
    }
}