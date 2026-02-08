<?php

use Illuminate\Support\Facades\Route;
use App\Domains\Patient\Controllers\PatientController;
use App\Domains\Auth\Controllers\AuthController;

Route::post('/api/auth/login', [AuthController::class, 'login']);
Route::middleware(['auth:sanctum'])
    ->post('/api/auth/register', [AuthController::class, 'register']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/auth/me', [AuthController::class, 'me']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);
});



