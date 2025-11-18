<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated and has super_admin role
        if (auth()->check() && auth()->user()->isSuperAdmin()) {
            return $next($request);
        }

        // If not SuperAdmin, redirect to home with error message
        return redirect('/')->with('error', 'Unauthorized access. SuperAdmin privileges required.');
    }
}
