<?php

namespace App\Domains\Auth\Services;

use App\Domains\Auth\Models\User;
use App\Domains\Auth\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthService
{
    /**
     * Register a new staff member with Role and Department assignment
     */
    public function register(array $data): User
    {
        return DB::transaction(function () use ($data) {
            $user = User::create([
                'name'          => $data['name'],
                'email'         => $data['email'],
                'password'      => Hash::make($data['password']),
                'department_id' => $data['department_id'] ?? null, // Added: Core for data isolation
                'is_active'     => true,
            ]);

            // Assign the selected role to the user
            $role = Role::where('name', $data['role'])->first();
            if ($role) {
                $user->roles()->attach($role);
            }

            return $user;
        });
    }

    /**
     * Handle staff login attempt
     */
    public function attemptLogin(string $email, string $password): ?User
    {
        $user = User::where('email', $email)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            return null;
        }

        // Security Check: Prevent access for deactivated staff
        if (!$user->is_active) {
            throw new \Exception('Access Denied: Your account is currently inactive.');
        }

        return $user;
    }
}
