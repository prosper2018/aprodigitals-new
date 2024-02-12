<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Parameter;

class CheckIdleTimeout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user()) {
            $lastActivity = session('last_activity');

            $inactivity_time =  Parameter::select('parameter_value')->where(['parameter_name' => 'inactivity_time'])->first();

            if ($lastActivity && (time() - $lastActivity) > (intval($inactivity_time->parameter_value) * 60)) { // Idle timeout duration in seconds (e.g., 30 minutes)
                Auth::logout(); // Logout the user
                return redirect('/login')->with('message', 'Session expired due to inactivity.');
            }
        }

        session(['last_activity' => time()]); // Update last activity timestamp
        return $next($request);
    }
}
