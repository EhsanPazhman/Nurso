<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Domains\Auth\Services\AuthService;
use Illuminate\Validation\ValidationException;

class Register extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $role = '';

    protected array $rules = [
        'name'     => 'required|string|max:255',
        'email'    => 'required|email|unique:users,email',
        'password' => 'required|min:8',
        'role'     => 'required|exists:roles,name',
    ];

    public function submit(AuthService $authService)
    {
        $this->validate();

        try {
            $authService->register([
                'name'     => $this->name,
                'email'    => $this->email,
                'password' => $this->password,
                'role'     => $this->role,
            ]);

            $this->dispatch(
                'notify',
                type: 'success',
                message: 'Staff registered successfully'
            );

            $this->reset(['name', 'email', 'password', 'role']);
        } catch (\Exception $e) {
            $this->addError('email', 'An error occurred during registration.');
        }
    }

    public function render()
    {
        return view('livewire.auth.register')->layout('layouts.app');
    }
}
