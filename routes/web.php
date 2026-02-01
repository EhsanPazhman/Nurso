<?php

use App\Livewire\Dashboard;
use App\Livewire\Auth\Login;
use Illuminate\Support\Facades\Route;

Route::get('/login', Login::class)->name('login');
Route::middleware('auth')->get('/dashboard', Dashboard::class)->name('dashboard');