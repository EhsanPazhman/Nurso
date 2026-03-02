<?php

namespace App\Livewire\Staff;

use Livewire\Component;
use Livewire\WithPagination;
use App\Domains\Auth\Models\User;
use App\Domains\Auth\Services\AuthService;

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

    public function toggleStatus(int $userId, AuthService $authService): void
    {
        $user = $authService->findById($userId); 
        $this->authorize('update', $user);

        $authService->toggleStatus($userId);

        $this->dispatch('notify', type: 'success', message: 'Staff status updated.');
    }

    public function deleteStaff(int $userId, AuthService $authService): void
    {
        $user = $authService->findById($userId);
        $this->authorize('delete', $user);

        try {
            $authService->deleteStaff($userId);
            $this->dispatch('notify', type: 'success', message: 'Staff member moved to trash.');
        } catch (\DomainException $e) {
            $this->dispatch('notify', type: 'error', message: $e->getMessage());
        }
    }

    public function restoreStaff(int $userId, AuthService $authService): void
    {
        $user = $authService->findTrashedById($userId);
        $this->authorize('restore', $user);

        $authService->restoreStaff($userId);

        $this->dispatch('notify', type: 'success', message: 'Staff member restored successfully.');
    }

    public function render(AuthService $authService)
    {
        $staff = $this->showTrashed
            ? $authService->getTrashedStaff($this->search, 10)
            : $authService->getStaffList($this->search, 10);

        return view('livewire.staff.staff-list', [
            'staffMembers' => $staff
        ])->layout('layouts.app');
    }
}
