<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Log;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if (Auth::check()) {
            Log::info('User is authenticated');
        Log::info('User is_admin: ' . Auth::user()->is_admin);
        Log::info('Roles expected: ' . $role);

            if (in_array(Auth::user()->is_admin, explode('-', $role))) {
                return $next($request);
            } else {
                abort(403);
            }
        } else {
            return redirect('/');
        }
    }
}
