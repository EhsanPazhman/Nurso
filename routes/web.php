<?php

use App\Livewire\Dashboard;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use Illuminate\Support\Facades\Route;

Route::get('/login', Login::class)->name('login');
Route::get('/', Login::class)->name('login');
Route::middleware('auth')->get('/dashboard', Dashboard::class)->name('dashboard');
Route::middleware(['auth'])
    ->get('/staff/register', Register::class)
    ->name('staff.register');


