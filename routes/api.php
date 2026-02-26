<?php

use Illuminate\Support\Facades\Route;
use App\Domains\Auth\Controllers\AuthController;
use App\Domains\Patient\Controllers\PatientController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
});

/*
|--------------------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->prefix('v1')->name('api.v1.')->group(function () {

    // Using 'patients' but namespaced with 'api.v1.' to avoid web conflicts
    Route::apiResource('patients', PatientController::class);

    Route::prefix('patients/{patient}')->group(function () {
        Route::post('/restore', [PatientController::class, 'restore'])
            ->name('patients.restore'); // Full name: api.v1.patients.restore

        Route::post('/vitals', [PatientController::class, 'storeVitals'])
            ->name('patients.vitals.store');
    });
});
