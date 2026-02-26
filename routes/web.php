<?php

use App\Livewire\Dashboard;
use App\Livewire\Auth\Login;
use App\Livewire\Staff\Register;
use App\Livewire\Staff\StaffList;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Patient\PatientForm;
use App\Livewire\Patient\PatientList;
use Illuminate\Support\Facades\Route;
use App\Livewire\Patient\RecordVitals;
use App\Livewire\Patient\GeneralVitalsMonitor;

/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
    Route::get('/', Login::class);
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::post('/logout', function () {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('login');
    })->name('logout');

    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    // =========================
    // Staff Management
    // =========================
    Route::prefix('staff')->name('staff.')->group(function () {
        Route::get('/', StaffList::class)
            ->middleware('can:viewAny,App\Domains\Auth\Models\User')
            ->name('index');

        Route::get('/create', Register::class)
            ->middleware('can:create,App\Domains\Auth\Models\User')
            ->name('create');

        Route::get('/{staff}/edit', Register::class)
            ->middleware('can:update,staff')
            ->name('edit');
    });

    // =========================
    // Patient Management
    // =========================
    Route::prefix('patients')->name('patients.')->group(function () {
        Route::get('/', PatientList::class)
            ->middleware('can:viewAny,App\Domains\Patient\Models\Patient')
            ->name('index');

        Route::get('/register', PatientForm::class)
            ->middleware('can:create,App\Domains\Patient\Models\Patient')
            ->name('create');

        Route::get('/clinical-monitor', GeneralVitalsMonitor::class)
            ->middleware('can:viewAny,App\Domains\Patient\Models\Patient')
            ->name('clinical.monitor');

        Route::get('/{patient}/edit', PatientForm::class)
            ->middleware('can:update,patient')
            ->name('edit');

        Route::get('/{patient}/vitals', RecordVitals::class)
            ->middleware('can:recordVitals,patient')
            ->name('vitals');
    });
});
