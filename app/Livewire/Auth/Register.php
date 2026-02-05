<?php

namespace App\Livewire\Auth;
use Livewire\Component;
use Illuminate\Support\Facades\Http;

class Register extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $role = '';

    protected array $rules = [
        'name'     => 'required|string|max:255',
        'email'    => 'required|email',
        'password' => 'required|min:8',
        'role'     => 'required',
    ];

    public function submit()
    {
        $this->validate();

        $response = Http::withToken(session('api_token'))
            ->post(url('/api/auth/register'), [
                'name'     => $this->name,
                'email'    => $this->email,
                'password' => $this->password,
                'role'     => $this->role,
            ]);
        if ($response->failed()) {
            $data = json_decode($response->body(), true);
            $message = isset($data['message']) ? $data['message'] : 'Registration failed';
            $this->addError('email', $message);
            return;
        }

        session()->flash('success', 'Staff registered successfully');

        $this->reset(['name', 'email', 'password', 'role']);
    }

    public function render()
    {
        return view('livewire.auth.register')
            ->layout('layouts.app');
    }
}
