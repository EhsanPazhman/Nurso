<?php

namespace App\Livewire\Staff;

use Livewire\Component;
use Livewire\WithPagination;
use App\Domains\Staff\Models\User;
use App\Domains\Staff\Services\StaffService;

class StaffList extends Component
{
    use WithPagination;

    public string $search = '';
    public bool $showTrashed = false;

    public function mount(): void
    {
        $this->authorize('viewAny', User::class);
    }

    public function toggleTrashView(): void
    {
        $this->showTrashed = !$this->showTrashed;
        $this->resetPage();
    }

    public function toggleStatus(int $userId, StaffService $staffService): void
    {
        $user = $staffService->findById($userId);
        $this->authorize('update', $user);

        $staffService->toggleStatus($userId);

        $this->dispatch('notify', type: 'success', message: 'Staff status updated.');
    }

    public function deleteStaff(int $userId, StaffService $staffService): void
    {
        $user = $staffService->findById($userId);
        $this->authorize('delete', $user);

        try {
            $staffService->deleteStaff($userId);
            $this->dispatch('notify', type: 'success', message: 'Staff member moved to trash.');
        } catch (\DomainException $e) {
            $this->dispatch('notify', type: 'error', message: $e->getMessage());
        }
    }

    public function restoreStaff(int $userId, StaffService $staffService): void
    {
        $user = $staffService->findTrashedById($userId);
        $this->authorize('restore', $user);

        $staffService->restoreStaff($userId);

        $this->dispatch('notify', type: 'success', message: 'Staff member restored successfully.');
    }

    public function render(StaffService $staffService)
    {
        $staff = $this->showTrashed
            ? $staffService->getTrashedStaff($this->search, 10)
            : $staffService->getStaffList($this->search, 10);

        return view('livewire.staff.staff-list', [
            'staffMembers' => $staff
        ])->layout('layouts.app');
    }
}
