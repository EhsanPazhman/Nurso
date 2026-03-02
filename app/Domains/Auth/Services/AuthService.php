<?php

namespace App\Domains\Auth\Services;

use App\Domains\Auth\Models\Role;
use App\Domains\Auth\Models\User;
use App\Domains\Auth\Repositories\AuthRepository;
use App\Domains\Department\Repositories\DepartmentRepository;
use DomainException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function __construct(
        protected AuthRepository $repository,
        protected DepartmentRepository $departmentRepository
    ) {}

    public function register(array $data): User
    {
        return DB::transaction(function () use ($data) {
            $user = $this->repository->create([
                'name'          => $data['name'],
                'email'         => $data['email'],
                'password'      => Hash::make($data['password']),
                'phone'         => $data['phone'] ?? null,
                'department_id' => $data['department_id'] ?? null,
                'is_active'     => true,
            ]);

            if (isset($data['role'])) {
                $role = Role::where('name', $data['role'])->first();
                if ($role) $user->roles()->attach($role);
            }

            return $user;
        });
    }

    public function getStaffList(string $search = '', int $perPage = 10)
    {
        return $this->repository->getStaffList($search, $perPage);
    }

    public function getTrashedStaff(string $search = '', int $perPage = 10)
    {
        return $this->repository->getTrashedStaff($search, $perPage);
    }

    public function updateStaff(int $userId, array $data): User
    {
        return DB::transaction(function () use ($userId, $data) {
            $user = $this->repository->findById($userId);

            $updateData = [
                'name'          => $data['name'],
                'email'         => $data['email'],
                'phone'         => $data['phone'] ?? $user->phone,
                'department_id' => $data['department_id'] ?? $user->department_id,
            ];

            if (!empty($data['password'])) {
                $updateData['password'] = Hash::make($data['password']);
            }

            $user->update($updateData);

            if (!empty($data['role'])) {
                $role = Role::where('name', $data['role'])->first();
                if ($role) $user->roles()->sync([$role->id]);
            }

            return $user;
        });
    }

    public function attemptLogin(string $email, string $password): User
    {
        $user = $this->repository->findByEmail($email);

        if (!$user || !Hash::check($password, $user->password)) {
            throw new DomainException('Invalid credentials.');
        }

        if (!$user->is_active) {
            throw new DomainException('User account inactive.');
        }

        return $user;
    }

    public function toggleStatus(int $userId): bool
    {
        $user = $this->repository->findById($userId);
        return $user->update(['is_active' => !$user->is_active]);
    }

    public function deleteStaff(int $userId): bool
    {
        if ($userId === auth()->id()) {
            throw new DomainException("Cannot delete yourself.");
        }

        $user = $this->repository->findById($userId);
        return $user->delete();
    }

    public function restoreStaff(int $userId): bool
    {
        $user = $this->repository->findTrashedById($userId);
        return $user->restore();
    }

    public function findById(int $id): User
    {
        return $this->repository->findById($id);
    }

    public function findTrashedById(int $id): User
    {
        return $this->repository->findTrashedById($id);
    }

    public function getRoles()
    {
        return $this->repository->getRoles();
    }
    public function getActiveDepartments()
    {
        return $this->departmentRepository->getActive();
    }
}
