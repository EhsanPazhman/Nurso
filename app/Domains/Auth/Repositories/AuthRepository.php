<?php

namespace App\Domains\Auth\Repositories;

use App\Domains\Auth\Models\Role;
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

    public function findTrashedById(int $id): User
    {
        return User::onlyTrashed()->findOrFail($id);
    }

    public function getRoles()
    {
        return Role::all();
    }
    public function getStaffList(string $search = '', int $perPage = 10): LengthAwarePaginator
    {
        return User::with(['roles', 'department', 'creator'])
            ->where('id', '!=', auth()->id())
            ->when($search, fn($q) => $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%"))
            ->latest()
            ->paginate($perPage);
    }

    public function getTrashedStaff(string $search = '', int $perPage = 10): LengthAwarePaginator
    {
        return User::onlyTrashed()
            ->with(['roles', 'department'])
            ->when($search, fn($q) => $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%"))
            ->latest()
            ->paginate($perPage);
    }

    public function create(array $data): User
    {
        return User::create($data);
    }

    public function getDoctors(?int $departmentId = null)
    {
        return User::whereHas('roles', fn($q) => $q->where('name', 'doctor'))
            ->when($departmentId, fn($q) => $q->where('department_id', $departmentId))
            ->get();
    }
}
