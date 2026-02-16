<?php

namespace App\Livewire\Staff;

use Livewire\Component;
use Livewire\WithPagination;
use App\Domains\Auth\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Domains\Auth\Services\AuthService;
use App\Domains\Auth\Repositories\AuthRepository;

class StaffList extends Component
{
    use WithPagination;

    public string $search = '';

public function mount(): void
{
    $this->authorize('viewAny', User::class);
}

public function deleteStaff(int $userId, AuthService $authService): void
{
    $userToDelete = User::findOrFail($userId);
    $this->authorize('delete', $userToDelete); 

    try {
        $authService->deleteStaff($userId);
        $this->dispatch('notify', type: 'success', message: 'Staff member moved to trash.');
    } catch (\DomainException $e) {
        $this->dispatch('notify', type: 'error', message: $e->getMessage());
    }
}

    public function toggleStatus(int $userId, AuthService $authService): void
    {
        $authService->toggleStatus($userId);
        $this->dispatch('notify', type: 'success', message: 'Staff status updated.');
    }

    public function render(AuthRepository $userRepository)
    {
        return view('livewire.staff.staff-list', [
            // Using Repository instead of direct Model query
            'staffMembers' => $userRepository->getStaffList($this->search, 10)
        ])->layout('layouts.app');
    }
}
