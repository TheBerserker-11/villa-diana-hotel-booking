<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {

                // ✅ OPTION A: Admins never see user pages
                if ((int) Auth::guard($guard)->user()->is_admin === 1) {
                    // prevent admin from being redirected to booking summary / intended
                    session()->forget(['redirect', 'url.intended']);
                    return redirect('/admin');
                }

                // ✅ Users: return to booking summary if they came from there
                $intended = session('redirect') ?? session('url.intended');

                if ($request->filled('redirect')) {
                    $intended = $request->get('redirect');
                    session([
                        'redirect'     => $intended,
                        'url.intended' => $intended,
                    ]);
                }

                return $intended
                    ? redirect()->to($intended)
                    : redirect(RouteServiceProvider::HOME);
            }
        }

        return $next($request);
    }
}