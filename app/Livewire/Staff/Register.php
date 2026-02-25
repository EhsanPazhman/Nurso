<?php

namespace App\Livewire\Staff;

use Livewire\Component;
use App\Domains\Auth\Models\User;
use App\Domains\Auth\Models\Role;
use App\Domains\Auth\Services\AuthService;
use App\Domains\Department\Models\Department;

class Register extends Component
{
    public ?User $staff = null; // Store user if in edit mode

    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $password = '';
    public string $role = '';
    public ?string $department_id = null; // String for better select-box matching

    public function mount(User $staff)
    {

        if ($staff->exists) {
            $this->staff = $staff;

            abort_unless(auth()->user()->can('update', $this->staff), 403);

            $this->fillStaffData();
        } else {
            abort_unless(auth()->user()->can('create', User::class), 403);

            $this->initializeNewStaff();
        }
    }

    protected function fillStaffData()
    {
        $this->name = $this->staff->name;
        $this->email = $this->staff->email;
        $this->phone = $this->staff->phone;
        $this->role = $this->staff->roles->first()?->name ?? '';
        $this->department_id = $this->staff->department_id;
    }
    protected function rules(): array
    {
        if ($this->staff) {
            return (new \App\Domains\Auth\Requests\UpdateStaffRequest(['id' => $this->staff->id]))->rules();
        }
        return (new \App\Domains\Auth\Requests\RegisterRequest())->rules();
    }

    public function submit(AuthService $authService)
    {
        if ($this->department_id === '') {
            $this->department_id = null;
        }

        $validated = $this->validate();

        try {
            if ($this->staff) {
                $authService->updateStaff($this->staff->id, $validated);
                $message = 'Staff record updated successfully.';
            } else {
                $authService->register($validated);
                $message = 'Staff member registered successfully.';
            }

            $this->dispatch('notify', type: 'success', message: $message);
            return $this->redirectRoute('staff', navigate: true);
        } catch (\Exception $e) {
            $this->addError('email', 'Operation failed: ' . $e->getMessage());
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
