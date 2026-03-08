<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectAdminToDashboard
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && (int) Auth::user()->is_admin === 1) {

            // ✅ allow logout to work
            if ($request->routeIs('logout')) {
                return $next($request);
            }

            // If trying to access NON-admin pages
            if (!$request->is('admin') && !$request->is('admin/*')) {
                return redirect('/admin');
            }
        }

        return $next($request);
    }
}