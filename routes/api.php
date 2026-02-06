<?php

use App\Livewire\Patient\PatientForm;
use App\Livewire\Patient\PatientList;
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


Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('patients', PatientController::class);
    Route::post('patients/{id}/restore', [PatientController::class, 'restore']);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/patients', PatientList::class)->name('patients.index');
    Route::get('/patients/create', PatientForm::class)->name('patients.create');
    Route::get('/patients/{patientId}/edit', PatientForm::class)->name('patients.edit');
});
