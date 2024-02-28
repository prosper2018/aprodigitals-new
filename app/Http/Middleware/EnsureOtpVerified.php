<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureOtpVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated and OTP is not verified
        if ($request->user() && $request->user()->is_mfa == '1' && !$request->user()->isOtpVerified()) {
            // Redirect the user to the OTP verification form or another appropriate route
            return redirect()->route('otp.verify.form')->with('error', 'Please verify your OTP first.');
        }

        return $next($request);
    }
}
