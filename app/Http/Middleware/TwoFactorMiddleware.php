<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TwoFactorMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // 1. Ensure user is logged in
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // 2. CRITICAL: If the user is already on a 2FA route, let them through!
        // This prevents the redirect loop you see in your logs.
        if ($request->is('admin/2fa/*')) {
            return $next($request);
        }

        // 3. If 2FA is set up but NOT verified for this session, go to challenge
        if ($user->google2fa_secret && !session('2fa_verified')) {
            return redirect()->route('admin.2fa.challenge');
        }

        // 4. If 2FA is NOT set up at all, go to setup
        if (!$user->google2fa_secret) {
            return redirect()->route('admin.2fa.setup');
        }

        return $next($request);
    }
}