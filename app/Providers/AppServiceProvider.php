<?php

namespace App\Providers;

use App\Domains\Auth\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->loadRoutesFrom(base_path('routes/api.php'));
        Gate::before(function (User $user, $ability) {
            if ($user->hasRole('super_admin')) {
                return true;
            }

            return $user->hasPermission($ability) ?: null;
        });
    }
}
