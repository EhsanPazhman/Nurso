<?php

use App\Models\Patient;
use App\Livewire\Patient\PatientForm;
use Illuminate\Support\Facades\Route;
use App\Livewire\Patient\PatientIndex;
use App\Livewire\Patient\PatientVitals;

Route::get('/', PatientIndex::class)->name('patients.index');
Route::group(['prefix' => 'patients'], function () {
    Route::get('create', PatientForm::class)->name('patients.create');
    Route::get('{patientId}/edit', PatientForm::class)->name('patients.edit');
    Route::get('{patientId}/vitals', PatientVitals::class)->name('patients.vitals');
});
