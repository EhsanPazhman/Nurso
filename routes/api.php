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

Route::middleware('auth:sanctum')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Auth
    |--------------------------------------------------------------------------
    */

    Route::prefix('auth')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);
        // Register staff through AuthController (admin only)
        Route::post('/register', [AuthController::class, 'register'])->middleware('can:create,App\Domains\Auth\Models\User');
    });

    /*
    |--------------------------------------------------------------------------
    | Patients
    |--------------------------------------------------------------------------
    */

    Route::apiResource('patients', PatientController::class);

    Route::post('patients/{patient}/restore', [PatientController::class, 'restore']);

    Route::post('patients/{patient}/vitals', [PatientController::class, 'storeVitals']);
});
