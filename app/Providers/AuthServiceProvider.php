<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use App\Domains\Auth\Models\User;
use App\Domains\Auth\Policies\UserPolicy;

use App\Domains\Patient\Models\Patient;
use App\Domains\Patient\Policies\PatientPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        User::class => UserPolicy::class,
        Patient::class => PatientPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
