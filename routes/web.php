<?php

use App\Livewire\Dashboard;
use App\Livewire\Auth\Login;
use App\Livewire\Staff\Register;
use App\Livewire\Staff\StaffList;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Patient\PatientForm;
use App\Livewire\Patient\PatientList;
use Illuminate\Support\Facades\Route;
use App\Domains\Patient\Controllers\PatientController;

Route::get('/login', Login::class)->name('login');
Route::get('/', Login::class)->name('login');

Route::post('/logout', function () {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect()->route('login');
})->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/staffs', StaffList::class)->name('staffs');
    Route::get('/staff/register', Register::class)->middleware('can:staff.register')->name('staff.register');
    Route::get('/staff/{staffId}/edit', Register::class)->middleware('can:staff.update')->name('staff.edit');

    Route::get('/patients', PatientList::class)->middleware('can:patient.view')->name('patients');
    Route::get('/patient/create', PatientForm::class)->middleware('can:patient.create')->name('patient.create');
    Route::get('/patient/{patientId}/edit', PatientForm::class)->middleware('can:patient.update')
        ->name('patient.edit');
});
