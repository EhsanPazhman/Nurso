<?php

namespace App\Livewire\Staff;

use Livewire\Component;
use App\Domains\Auth\Models\User;
use App\Domains\Auth\Models\Role;
use App\Domains\Auth\Services\AuthService;
use App\Domains\Department\Models\Department;
use App\Domains\Auth\Requests\RegisterRequest;
use App\Domains\Auth\Requests\UpdateStaffRequest;

class Register extends Component
{
    public ?User $staff = null; // Store user if in edit mode

    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $password = '';
    public string $role = '';
    public ?string $department_id = null; // String for better select-box matching

    public function mount(?int $staffId = null)
    {
        if ($staffId) {
            $this->staff = User::findOrFail($staffId);

            $this->authorize('update', $this->staff);

            $this->name = $this->staff->name;
            $this->email = $this->staff->email;
            $this->phone = $this->staff->phone ?? '';
            $this->department_id = (string) $this->staff->department_id;
            $this->role = $this->staff->roles->first()?->name ?? '';
        } else {
            $this->authorize('create', User::class);
        }
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
            return $this->redirectRoute('staffs', navigate: true);
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
