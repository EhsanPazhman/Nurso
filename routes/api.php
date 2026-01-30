<?php

use App\Livewire\Patient\PatientForm;
use App\Livewire\Patient\PatientList;
use Illuminate\Support\Facades\Route;
use App\Domains\Patient\Controllers\PatientController;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('patients', PatientController::class);
    Route::post('patients/{id}/restore', [PatientController::class, 'restore']);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/patients', PatientList::class)->name('patients.index');
    Route::get('/patients/create', PatientForm::class)->name('patients.create');
    Route::get('/patients/{patientId}/edit', PatientForm::class)->name('patients.edit');
});
