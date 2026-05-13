<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string[] ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Ensure user is logged in
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // 2. Check if user's role exists in the allowed roles (1, 2, or 3)
        // We use (string) to ensure compatibility with the route parameters
        if (in_array((string)$user->role, $roles)) {
            return $next($request);
        }

        // 3. FIX: Unauthorized access
        // Instead of just redirecting, we log them out.
        // This prevents "Residents" from being stuck in a session they can't use for Admin tasks.
        Auth::logout();

        // Clear the session to be safe
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('error', 'Access Denied: Your account does not have administrative privileges.');
    }
}