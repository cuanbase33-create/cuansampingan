<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeadersMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($response instanceof Response) {
            $response->headers->set('X-Content-Type-Options', 'nosniff');
            $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
            // Disable deprecated XSS auditor as recommended by OWASP when using CSP
            $response->headers->set('X-XSS-Protection', '0');
            $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
            $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');

            if ($request->isSecure()) {
                $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
            }
            
            // Hardened Content-Security-Policy
            $csp = "default-src 'self'; " .
                   "base-uri 'self'; " .
                   "object-src 'none'; " .
                   "form-action 'self' https:; " .
                   "img-src 'self' data: https: blob:; " .
                   "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.tailwindcss.com https://cdn.jsdelivr.net https://cdn.tiny.cloud https://*.tinymce.com https://*.tiny.cloud https://cdn.ckeditor.com; " .
                   "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdn.tiny.cloud https://cdn.ckeditor.com; " .
                   "font-src 'self' https://fonts.gstatic.com; " .
                   "frame-src 'self' https://www.youtube.com https://www.youtube-nocookie.com https://player.vimeo.com; " .
                   "connect-src 'self' https://*.tiny.cloud https://*.tinymce.com;";
            
            $response->headers->set('Content-Security-Policy', $csp);
        }

        return $response;
    }
}
