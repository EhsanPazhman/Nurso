<?php

namespace App\Domains\Auth\Services;

use App\Domains\Staff\Models\User;
use App\Domains\Staff\Repositories\StaffRepository;
use App\Domains\Department\Repositories\DepartmentRepository;
use DomainException;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function __construct(
        protected StaffRepository $repository,
        protected DepartmentRepository $departmentRepository
    ) {}

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
}
