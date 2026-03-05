<?php

namespace App\Livewire\Staff;

use App\Domains\Staff\Models\User;
use App\Domains\Staff\Requests\UpdateStaffRequest;
use App\Domains\Staff\Requests\RegisterStaffRequest;
use App\Domains\Staff\Services\StaffService;
use Livewire\Component;

class Register extends Component
{
    public ?User $staff = null;

    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $password = '';
    public string $role = '';
    public ?string $department_id = null;

    public function mount(?User $staff = null)
    {
        if ($staff && $staff->exists) {
            $this->authorize('update', $staff);

            $this->staff = $staff;
            $this->fillStaffData();
        } else {
            $this->authorize('create', User::class);
        }
    }

    protected function fillStaffData(): void
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
            return (new UpdateStaffRequest(['id' => $this->staff->id]))->rules();
        }

        return (new RegisterStaffRequest())->rules();
    }

    public function submit(StaffService $staffService)
    {
        if ($this->department_id === '') {
            $this->department_id = null;
        }

        $validated = $this->validate();

        try {
            if ($this->staff) {
                $this->authorize('update', $this->staff);
                $staffService->updateStaff($this->staff->id, $validated);
                $message = 'Staff record updated successfully.';
            } else {
                $this->authorize('create', User::class);
                $staffService->register($validated);
                $message = 'Staff member registered successfully.';
            }

            $this->dispatch('notify', type: 'success', message: $message);

            return $this->redirectRoute('staff.index', navigate: true);
        } catch (\Exception $e) {
            $this->addError('email', 'Operation failed: ' . $e->getMessage());
        }
    }

    public function render(StaffService $staffService)
    {
        return view('livewire.staff.register', [
            'roles' => $staffService->getRoles(),
            'departments' => $staffService->getActiveDepartments(),
        ])->layout('layouts.app');
    }
}
