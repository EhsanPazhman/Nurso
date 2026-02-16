<?php

namespace App\Providers;

use App\Domains\Auth\Models\User;
use App\Policies\UserPolicy;
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

        // 1. Manually Register Policies for DDD Structure
        Gate::policy(User::class, UserPolicy::class);

        // 2. Super Admin "God Mode" & Permission Check
        Gate::before(function (User $user, $ability) {
            // Super Admin bypasses all checks
            if ($user->hasRole('super_admin')) {
                return true;
            }

            // Check if the user has specific permission for this ability
            return $user->hasPermission($ability) ?: null;
        });
    }
}
