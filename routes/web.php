<?php

use App\Livewire\Admin\UserManagement;
use App\Models\Patient;
use App\Livewire\Dashboard;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Patient\PatientForm;
use Illuminate\Support\Facades\Route;
use App\Livewire\Patient\PatientIndex;
use App\Livewire\Patient\PatientVitals;

Route::middleware(['guest'])->group(function () {
    Route::get('/login', Login::class)->name('login');
});
Route::middleware(['auth'])->group(function () {
    Route::get('staff/register', Register::class)->name('register');
    Route::get('/', Dashboard::class)->name('dashboard');
    Route::get('/dashboard/staffs', UserManagement::class)->name('staffs');
    Route::group(['prefix' => 'patients'], function () {
        Route::get('/', PatientIndex::class)->name('patients.index');
        Route::get('create', PatientForm::class)->name('patients.create');
        Route::get('{patientId}/edit', PatientForm::class)->name('patients.edit');
        Route::get('{patientId}/vitals', PatientVitals::class)->name('patients.vitals');
    });
});
Route::get('/logout', function () {
    auth()->logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect()->route('login');
})->name('logout');
