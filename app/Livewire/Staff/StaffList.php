<?php

namespace App\Livewire\Staff;

use Livewire\Component;
use App\Domains\Auth\Models\User;
use App\Domains\Auth\Services\AuthService;
use App\Domains\Auth\Repositories\AuthRepository;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

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
        $authService->toggleStatus($userId);
        $this->dispatch('notify', type: 'success', message: 'Staff status updated.');
    }

    public function deleteStaff(int $userId, AuthService $authService): void
    {
        try {
            $authService->deleteStaff($userId);
            $this->dispatch('notify', type: 'success', message: 'Staff member moved to trash.');
        } catch (\DomainException $e) {
            $this->dispatch('notify', type: 'error', message: $e->getMessage());
        }
    }

    public function restoreStaff(int $userId, AuthService $authService): void
    {
        $authService->restoreStaff($userId);
        $this->dispatch('notify', type: 'success', message: 'Staff member restored successfully.');
    }

    public function render(AuthRepository $userRepository)
    {
        // Decide which list to fetch based on toggle
        $staff = $this->showTrashed
            ? $userRepository->getTrashedStaff($this->search, 10)
            : $userRepository->getStaffList($this->search, 10);

        return view('livewire.staff.staff-list', [
            'staffMembers' => $staff
        ])->layout('layouts.app');
    }
}
