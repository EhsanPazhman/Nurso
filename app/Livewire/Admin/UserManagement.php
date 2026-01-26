<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UserManagement extends Component
{
    public $search = '';
    public $filterRole = '';
    public function delete($id)
    {
        if ($id == auth()->id()) {
            session()->flash('error', 'You cannot remove your own account.');
            return;
        }
        $user = User::findOrFail($id);
        $user->delete();
        session()->flash('success', 'User removed successfully.');
    }
    public function render()
    {
        return view('livewire.admin.user-management', ['users' => User::query()
            ->when($this->filterRole, function ($query) {
                $query->where('role', $this->filterRole);
            })
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })->latest()->paginate(10)])->layout('layouts.app');
    }
}
