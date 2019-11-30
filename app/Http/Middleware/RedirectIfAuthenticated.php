<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            if(Auth::user()->role == 3) {
                return redirect('/subadmin');
            } elseif(Auth::user()->role == 2) {
                return redirect('/admin');
            } elseif(Auth::user()->role == 1)  {
                return redirect('/dashboard');
            }
        }

        return $next($request);
    }
}
