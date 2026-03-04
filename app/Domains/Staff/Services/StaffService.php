<?php

namespace App\Domains\Staff\Services;

use App\Domains\Staff\Repositories\StaffRepository;
use App\Domains\Department\Repositories\DepartmentRepository;
use App\Domains\Staff\Models\User;
use DomainException;
use Illuminate\Support\Facades\DB;

class StaffService
{
    public function __construct(
        protected StaffRepository $repository,
        protected DepartmentRepository $departmentRepository
    ) {}

    public function register(array $data): User
    {
        return DB::transaction(function () use ($data) {
            $user = $this->repository->create($data);

            if (!empty($data['role'])) {
                $this->repository->assignRole($user, $data['role']);
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

            if (empty($data['password'])) {
                unset($data['password']);
            }

            $user = $this->repository->update($user, $data);

            if (!empty($data['role'])) {
                $this->repository->syncRole($user, $data['role']);
            }

            return $user;
        });
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
