<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class Login extends Component
{
    public string $email = '';
    public string $password = '';

    public function login()
    {
        $response = Http::post(url('/api/auth/login'), [
            'email'    => $this->email,
            'password' => $this->password,
        ]);

        if ($response->failed()) {
            $this->addError('email', 'Invalid email or password');
            return;
        }

        session(['api_token' => $response->json('token')]);

        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.auth.login')->layout('layouts.guest');
    }
}
