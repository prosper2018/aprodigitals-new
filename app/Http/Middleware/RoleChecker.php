<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Support\Facades\Auth;

class RoleChecker
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    // public function handle($request, Closure $next)
    // {
    //     return $next($request);
    // }
    public function handle($request, Closure $next, $clientsRole, $systemAdminRole, $superAdminRole)
    {
        $roles = Auth::check() ? Auth::user()->position_id->pluck('position_id')->toArray() : [];

        if (in_array($clientsRole, $roles)) {
            return $next($request);
        } else if (in_array($systemAdminRole, $roles)) {
            return $next($request);
        } else if (in_array($superAdminRole, $roles)) {
            return $next($request);
        }

        return redirect()->route('home');
    }
}
