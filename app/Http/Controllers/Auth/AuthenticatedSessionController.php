<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $user = Auth::user();

        // If the user already has an active session elsewhere, block this login.
        if ($user->session_token !== null) {
            Auth::guard('web')->logout();

            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'This account is already logged in on another device. Please log out from that device first.']);
        }

        $request->session()->regenerate();

        // Stamp a unique token so any future concurrent login attempt is blocked.
        $token = Str::random(60);
        $user->session_token = $token;
        $user->save();
        $request->session()->put('session_token', $token);

        return redirect()->intended(route('dashboardv2', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = Auth::user();
        if ($user) {
            $user->session_token = null;
            $user->save();
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
