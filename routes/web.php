<?php

use App\Livewire\Dashboard;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Patient\PatientList;
use Illuminate\Support\Facades\Route;
use App\Domains\Patient\Controllers\PatientController;

Route::get('/login', Login::class)->name('login');
Route::get('/', Login::class)->name('login');
Route::middleware('auth')->get('/dashboard', Dashboard::class)->name('dashboard');
Route::middleware(['auth'])
    ->get('/staff/register', Register::class)
    ->name('staff.register');

Route::middleware(['auth'])->group(function () {

    Route::get('/patients', PatientList::class)->middleware('can:patient.view')->name('patients');
    
    Route::resource('patients', PatientController::class)->except(['index']);
    Route::post('patients/{id}/restore', [PatientController::class, 'restore'])->name('patients.restore');
});

