<?php

use Illuminate\Support\Facades\Route;
use App\Domains\Patient\Controllers\PatientController;
use App\Domains\Auth\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::post('/auth/login', [AuthController::class, 'login']);

/*
|--------------------------------------------------------------------------
| Protected Routes (Sanctum)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

    // Auth & Staff Management
    Route::prefix('auth')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/register', [AuthController::class, 'register']); 
    });

    // Patient Domain
    Route::apiResource('patients', PatientController::class)->except(['index']);
    Route::post('patients/{id}/restore', [PatientController::class, 'restore'])->name('patients.restore');

    // Future: Add Staff Controller here for external API consumers
    // Route::apiResource('staff', StaffController::class);
});
