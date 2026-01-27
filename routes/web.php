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
    Route::get('/', Dashboard::class)->name('dashboard');
    Route::group(['prefix' => 'dashboard'], function () {
        Route::get('/staff/register', Register::class)->name('user.register');
        Route::get('/staff/{id}/edit', Register::class)->name('user.edit');
        Route::get('/staffs', UserManagement::class)->name('staffs');
        Route::get('/patients', PatientIndex::class)->name('patients.index');
        Route::get('/patient/create', PatientForm::class)->name('patients.create');
        Route::get('/patient/{patientId}/edit', PatientForm::class)->name('patients.edit');
        Route::get('/patient/{patientId}/vitals', PatientVitals::class)->name('patients.vitals');
    });
});
Route::get('/logout', function () {
    auth()->guard()->logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect()->route('login');
})->name('logout');
