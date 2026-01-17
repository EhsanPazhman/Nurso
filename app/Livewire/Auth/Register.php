<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;

class Register extends Component
{
    public ?int $id = null;
    public $name, $email, $role = 'nurse', $password;

    public function mount($id = null)
    {
        if ($id) {
            $user = User::findOrFail($id);
            $this->id       = $user->id; 
            $this->name     = $user->name;
            $this->email    = $user->email;
            $this->role     = $user->role;
        }
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->id,
            'role' => 'required|in:admin,supervisor,nurse',
            'password' => $this->id ? 'nullable|min:8' : 'required|min:8',
        ]);

        $creator = auth()->user();

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
        ];

        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        if (!$this->id) {
            $data['parent_id'] = $creator->id;
        }

        $newUser = User::updateOrCreate(['id' => $this->id], $data);

        if (!$this->id || empty($newUser->path)) {
            $newUser->update([
                'path' => ($creator->path ?? '') . $newUser->id . '/',
            ]);
        }

        session()->flash('success', 'Staff account updated/deployed successfully!');
        return redirect()->route('staffs');
    }

    public function render()
    {
        return view('livewire.auth.register')->layout('layouts.app');
    }
}
