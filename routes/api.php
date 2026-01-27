<?php

use App\Domains\Patient\Controllers\PatientController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('patients', PatientController::class);
    Route::post('patients/{id}/restore', [PatientController::class, 'restore']);
});
