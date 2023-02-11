<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAuthenticated
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
        // Check if there is a user
        if (!session()->has('user')) {

            // Redirect User To Login Route
            return redirect()->route('login');
        } 

         // Proceed
         return $next($request);

        
    }
}
