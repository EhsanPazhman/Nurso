<?php

namespace App\Livewire\Auth;

use App\Domains\Auth\Services\AuthService;
use Livewire\Component;

class Login extends Component
{
    public string $email = '';
    public string $password = '';
    public bool $remember = false;

    public function login(AuthService $authService)
    {
        try {
            $user = $authService->attemptLogin($this->email, $this->password);

            auth()->login($user, $this->remember);

            session()->regenerate();

            return redirect()->intended('dashboard');
        } catch (\DomainException $e) {
            $this->addError('email', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.auth.login')->layout('layouts.guest');
    }
}
