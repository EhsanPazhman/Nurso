<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use App\Domains\Staff\Models\User;
use App\Domains\Staff\Policies\StaffPolicy;

use App\Domains\Patient\Models\Patient;
use App\Domains\Patient\Policies\PatientPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        User::class => StaffPolicy::class,
        Patient::class => PatientPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
