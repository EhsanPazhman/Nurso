<?php

namespace App\Providers;

use App\Domains\Patient\Models\Patient; 
use App\Domains\Patient\Policies\PatientPolicy; 
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Patient::class => PatientPolicy::class,
    ];

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        foreach ($this->policies as $model => $policy) {
            Gate::policy($model, $policy);
        }
    }
}
