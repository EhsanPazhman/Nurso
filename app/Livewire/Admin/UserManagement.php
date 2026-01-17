<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UserManagement extends Component
{
    public function render()
    {
        return view('livewire.admin.user-management', ['users' => User::paginate(10)])->layout('layouts.app');
    }
}
