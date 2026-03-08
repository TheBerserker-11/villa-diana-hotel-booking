<?php

namespace App\Providers;

use App\Models\Order;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Make Laravel pagination render Bootstrap 5 markup
        Paginator::useBootstrapFive();

        // Flag for admin views (if used for styling/logic)
        View::composer('admin.*', function ($view) {
            $view->with('adminView', true);
        });

        // Booking status notifications for logged-in customers
        View::composer('layouts.header', function ($view) {
            $bookingNotifs = collect();
            $bookingNotifCount = 0;

            if (Auth::check() && !(bool) Auth::user()->is_admin) {
                $notifQuery = Order::with('room.roomtype')
                    ->where('user_id', Auth::id())
                    ->whereIn('status', ['confirmed', 'approved', 'cancelled'])
                    ->orderByDesc('updated_at');

                $bookingNotifCount = (clone $notifQuery)->count();
                $bookingNotifs = $notifQuery->limit(7)->get();
            }

            $view->with([
                'bookingNotifs' => $bookingNotifs,
                'bookingNotifCount' => $bookingNotifCount,
            ]);
        });

        // Force HTTPS only in production
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
            $this->app['request']->server->set('HTTPS', 'on');
        }
    }
}
