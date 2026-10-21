<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TwoFactorVerified
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $admin = Auth::guard('admin')->user();

        if (!$admin) {
            return redirect()->route('admin.login');
        }

        // If 2FA has not been verified in the session yet, redirect to 2FA page
        if (!session()->get('admin_2fa_verified', false)) {
            return redirect()->route('admin.2fa');
        }

        return $next($request);
    }
}
