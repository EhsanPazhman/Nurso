<?php

use App\Livewire\Patient\PatientList;
use App\Livewire\Patient\PatientForm;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/patients', PatientList::class)->name('patients.index');
    Route::get('/patients/create', PatientForm::class)->name('patients.create');
    Route::get('/patients/{patientId}/edit', PatientForm::class)->name('patients.edit');
});
