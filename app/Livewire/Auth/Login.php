<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Domains\Auth\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class Login extends Component
{
    public string $email = '';
    public string $password = '';

    public function login()
    {
        $this->resetErrorBag();
        $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Please enter your email.',
            'email.email' => 'The email format is invalid.',
            'password.required' => 'Password is required.',
        ]);
        $response = Http::post(url('/api/auth/login'), [
            'email'    => $this->email,
            'password' => $this->password,
        ]);

        if ($response->failed()) {
            $this->addError('email', 'Invalid email or password');
            return;
        }

        session(['api_token' => $response->json('token')]);
        $user = User::where('email', $this->email)->first();
        Auth::login($user);
        return redirect()
            ->route('dashboard')
            ->with('notify', [
                'type' => 'success',
                'message' => 'Logged in successfully',
            ]);
    }

    public function render()
    {
        return view('livewire.auth.login')->layout('layouts.guest');
    }
}
