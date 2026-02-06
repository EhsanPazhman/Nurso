<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class Logout extends Component
{
    public function logout()
    {
        if (session()->has('api_token')) {
            Http::withToken(session('api_token'))->post(url('/api/auth/logout'));
            session()->forget('api_token');
        }

        session()->flash('success', 'You have been logged out');
        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.auth.logout');
    }
}
