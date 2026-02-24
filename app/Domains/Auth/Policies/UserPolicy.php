<?php

namespace App\Policies;

use App\Domains\Auth\Models\User;

class UserPolicy
{
    /**
     * Global bypass for super administrators.
     */
    public function before(User $user): ?bool
    {
        if ($user->hasRole('super_admin')) {
            return true;
        }

        return null;
    }

    /**
     * Determine whether the user can view the staff list.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('staff.view');
    }

    /**
     * Determine whether the user can create a staff account.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('staff.create')
            && $user->hasRole('hospital_admin');
    }

    /**
     * Determine whether the user can update a specific staff member.
     */
    public function update(User $user, User $model): bool
    {
        if (!$user->hasPermission('staff.update')) {
            return false;
        }

        // Allow self profile update
        if ($user->id === $model->id) {
            return true;
        }

        return $user->hasRole('hospital_admin');
    }

    /**
     * Determine whether the user can delete a specific staff member.
     */
    public function delete(User $user, User $model): bool
    {
        if (!$user->hasPermission('staff.delete')) {
            return false;
        }

        // Prevent self deletion
        if ($user->id === $model->id) {
            return false;
        }

        return $user->hasRole('hospital_admin');
    }
}
