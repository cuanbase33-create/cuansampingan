<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use PragmaRX\Google2FA\Google2FA;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class AdminAuthController extends Controller
{
    /**
     * Show admin login view.
     */
    public function showLogin()
    {
        if (Auth::guard('admin')->check() && session('admin_2fa_verified')) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }

    /**
     * Handle login authentication with rate limiting.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $throttleKey = Str::transliterate(Str::lower($request->input('email')) . '|' . $request->ip());

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()->withErrors([
                'email' => "Terlalu banyak percobaan login. Silakan coba lagi dalam {$seconds} detik.",
            ])->onlyInput('email');
        }

        if (Auth::guard('admin')->attempt($credentials)) {
            RateLimiter::clear($throttleKey);
            $request->session()->regenerate();
            session(['admin_2fa_verified' => false]);
            return redirect()->route('admin.2fa');
        }

        RateLimiter::hit($throttleKey, 300);

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /**
     * Handle logout.
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }

    /**
     * Show 2FA setup or verification view.
     */
    public function show2fa()
    {
        $admin = Auth::guard('admin')->user();
        if (!$admin) {
            return redirect()->route('admin.login');
        }

        if (session('admin_2fa_verified')) {
            return redirect()->route('admin.dashboard');
        }

        $google2fa = new Google2FA();
        $qrCodeSvg = null;
        $isSetup = false;
        $secret = '';

        if (is_null($admin->two_factor_secret)) {
            $isSetup = true;
            $secret = session('temp_2fa_secret');
            if (!$secret) {
                $secret = $google2fa->generateSecretKey();
                session(['temp_2fa_secret' => $secret]);
            }

            $qrCodeUrl = $google2fa->getQRCodeUrl(
                'CUANBASE',
                $admin->email,
                $secret
            );

            // Render QR Code to SVG using BaconQrCode
            $renderer = new ImageRenderer(
                new RendererStyle(200),
                new SvgImageBackEnd()
            );
            $writer = new Writer($renderer);
            $qrCodeSvg = $writer->writeString($qrCodeUrl);
        } else {
            // Do not pass existing secret to view to prevent unnecessary exposure
            $secret = '';
        }

        return view('admin.auth.2fa', compact('qrCodeSvg', 'isSetup', 'secret'));
    }

    /**
     * Verify 2FA OTP code with rate limiting and anti-replay protection.
     */
    public function verify2fa(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6',
        ]);

        $admin = Auth::guard('admin')->user();
        if (!$admin) {
            return redirect()->route('admin.login');
        }

        $throttleKey = '2fa_verify_' . $admin->id . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()->withErrors([
                'otp' => "Terlalu banyak percobaan kode OTP. Silakan coba lagi dalam {$seconds} detik.",
            ]);
        }

        $google2fa = new Google2FA();
        $otp = $request->input('otp');

        if (is_null($admin->two_factor_secret)) {
            $secret = session('temp_2fa_secret');
            if (!$secret) {
                return redirect()->route('admin.2fa')->withErrors(['otp' => 'Sesi setup 2FA telah kadaluarsa. Silakan coba lagi.']);
            }

            if ($google2fa->verifyKey($secret, $otp)) {
                RateLimiter::clear($throttleKey);

                $admin->two_factor_secret = $secret;
                $admin->two_factor_confirmed_at = now();
                $admin->save();

                session()->forget('temp_2fa_secret');
                session(['admin_2fa_verified' => true]);

                return redirect()->route('admin.dashboard');
            }
        } else {
            // Anti-replay protection: prevent reusing the same OTP code within its valid window
            $replayCacheKey = 'used_otp_' . $admin->id . '_' . $otp;
            if (Cache::has($replayCacheKey)) {
                RateLimiter::hit($throttleKey, 300);
                return back()->withErrors(['otp' => 'Kode OTP sudah pernah digunakan. Mohon tunggu kode berikutnya.']);
            }

            if ($google2fa->verifyKey($admin->two_factor_secret, $otp)) {
                RateLimiter::clear($throttleKey);
                // Mark this OTP as used for 120 seconds
                Cache::put($replayCacheKey, true, 120);

                session(['admin_2fa_verified' => true]);
                return redirect()->route('admin.dashboard');
            }
        }

        RateLimiter::hit($throttleKey, 300);

        return back()->withErrors(['otp' => 'Kode OTP tidak valid atau kadaluarsa.']);
    }
}
