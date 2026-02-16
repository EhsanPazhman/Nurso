<?php

namespace App\Domains\Auth\Repositories;

use App\Domains\Auth\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class AuthRepository
{
    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function findById(int $id): User
    {
        return User::findOrFail($id);
    }

    /**
     * Get paginated staff with filters for the StaffList
     */
    public function getStaffList(string $search = '', int $perPage = 10): LengthAwarePaginator
    {
        return User::with(['roles', 'department', 'creator'])
            ->where('id', '!=', auth()->id())
            ->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate($perPage);
    }
}
