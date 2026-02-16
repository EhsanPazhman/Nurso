<?php

namespace App\Livewire\Staff;

use Livewire\Component;
use App\Domains\Auth\Models\User;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class StaffList extends Component
{
    use WithPagination;

    public $search = '';

    public function mount()
    {
        abort_unless(Auth::user()->hasRole('super_admin'), 403);
    }

    public function toggleStatus($userId)
    {
        $user = User::findOrFail($userId);
        $user->update(['is_active' => !$user->is_active]);
        $this->dispatch('notify', type: 'success', message: 'Staff status updated.');
    }

    public function render()
    {
        $staff = User::with(['roles', 'department'])
            ->where('id', '!=', Auth::id()) 
            ->where(function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                    ->orWhere('email', 'like', "%{$this->search}%");
            })
            ->latest()
            ->paginate(10);

        return view('livewire.staff.staff-list', [
            'staffMembers' => $staff
        ])->layout('layouts.app');
    }
}
