<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;


class AdminControl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
      
        if (auth()->check() && auth()->user()->userType && auth()->user()->userType->name === $role) {
         
            return $next($request);
        }else{
            abort(403, 'Unauthorized access');
        }

        // if (auth()->check() || auth()->user()->userType->name !== $role) {
        //     abort(403, 'Unauthorized access');
        // }
        // return $next($request);
        
    }
    

    
}
