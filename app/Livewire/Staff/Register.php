<?php

namespace App\Livewire\Staff;

use Livewire\Component;
use App\Domains\Auth\Services\AuthService;
use App\Domains\Department\Models\Department; 
use App\Domains\Auth\Models\Role;

class Register extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $role = '';
    public ?int $department_id = null;

    protected array $rules = [
        'name'          => 'required|string|max:255',
        'email'         => 'required|email|unique:users,email',
        'password'      => 'required|min:8',
        'role'          => 'required|exists:roles,name',
        'department_id' => 'required|exists:departments,id',
    ];

    public function submit(AuthService $authService)
    {
        $this->validate();

        try {
            $authService->register([
                'name'          => $this->name,
                'email'         => $this->email,
                'password'      => $this->password,
                'role'          => $this->role,
                'department_id' => $this->department_id, 
            ]);

            $this->dispatch(
                'notify',
                type: 'success',
                message: 'Staff member registered and assigned to department.'
            );

            $this->reset(['name', 'email', 'password', 'role', 'department_id']);
        } catch (\Exception $e) {
            $this->addError('email', 'An error occurred during registration.');
        }
    }

    public function render()
    {
        return view('livewire.staff.register', [
            'roles' => Role::all(),
            'departments' => Department::where('is_active', true)->get(), 
        ])->layout('layouts.app');
    }
}
