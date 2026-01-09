<?php

use App\Models\Patient;
use App\Livewire\Patient\PatientForm;
use Illuminate\Support\Facades\Route;

Route::get('/',PatientForm::class);
