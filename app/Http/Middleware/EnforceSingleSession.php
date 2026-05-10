<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnforceSingleSession
{
    /**
     * Handle an incoming request.
     *
     * Check that the session token stored in the current session matches the
     * token recorded in the users table. If they differ, another browser has
     * logged in more recently, so this session is invalidated and the user
     * is redirected to the login page with an explanatory message.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            $sessionToken = $request->session()->get('session_token');

            // The session token in this browser must match what's in the DB.
            // If they differ the user has been logged out (e.g. admin action).
            if ($user->session_token !== $sessionToken) {
                Auth::guard('web')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')
                    ->withErrors(['email' => 'Your session is no longer valid. Please log in again.']);
            }
        }

        return $next($request);
    }
}
