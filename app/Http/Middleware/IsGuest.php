<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsGuest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if authenticated
        if (session()->has('user')) {

            // Redirect User To Admin
            return redirect()->route('dashboard.index');
        }

         // Proceed
         return $next($request);
    }
}
