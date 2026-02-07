<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. If the user is not authenticated, send them to the login page.
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // 2. Check if the authenticated user has admin privileges.
        // Casting to (int) handles both string '1' and integer 1 from the DB.
        if ((int)Auth::user()->is_admin === 1) {
            return $next($request);
        }

        /**
         * 3. PROTECTION AGAINST REDIRECT LOOPS:
         * If the user is logged in but is NOT an admin, we must kill the session.
         * Otherwise, the browser keeps trying to access /admin/dashboard, 
         * failing, and bouncing back and forth.
         */
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('error', 'Unauthorized access. Admin privileges required.');
    }
}