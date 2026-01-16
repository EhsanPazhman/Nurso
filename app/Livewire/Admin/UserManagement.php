<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;

class UserManagement extends Component
{
    public $name, $email, $role = 'nurse', $password;

    public function store()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:admin,supervisor,nurse',
            'password' => 'required|min:8',
        ]);

        $creator = auth()->user();

        $newUser = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => $this->role,
            'parent_id' => $creator->id,
        ]);
        $newUser->update([
            'path' => ($creator->path ?? '') . $newUser->id . '/',
        ]);

        session()->flash('success', 'Staff account deployed successfully!');
        return redirect()->intended(route('dashboard'));
    }

    public function render()
    {
        return view('livewire.admin.user-management')->layout('layouts.app');
    }
}
