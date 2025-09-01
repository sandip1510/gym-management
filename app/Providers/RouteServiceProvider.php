<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/dashboard';

    public function boot(): void
    {
        $this->routes(function () {
            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));
        });
    }

    // 👇 Add this method
    protected function redirectTo($request)
    {
        $user = $request->user();
        if ($user->hasRole('admin')) {
            return '/admin/dashboard';
        } elseif ($user->hasRole('trainer')) {
            return '/trainer/dashboard';
        } elseif ($user->hasRole('member')) {
            return '/member/dashboard';
        }

        return self::HOME;
    }
}
