<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        /* ---------- Register custom rate-limiters here ---------- */
        RateLimiter::for('login-demo', function (Request $request) {
            $email = (string) $request->input('email');

            // 5 attempts per minute per email+IP
            return Limit::perMinute(5)->by($email . $request->ip());
        });

        /* (keep any existing code such as model bindings or route groups) */

        parent::boot();
    }
}
