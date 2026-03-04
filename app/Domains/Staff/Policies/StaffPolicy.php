<?php

namespace App\Domains\Staff\Policies;

use App\Domains\Staff\Models\User;

class StaffPolicy
{
    /**
     * Global bypass for super administrators and block inactive users.
     */
    public function before(User $user, string $ability): ?bool
    {
        if (!$user->is_active) {
            return false;
        }

        if ($user->hasPermission('system.super')) {
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
        return $user->hasPermission('staff.create');
    }

    /**
     * Determine whether the user can update a specific staff member.
     */
    public function update(User $user, User $model): bool
    {
        if ($user->hasPermission('staff.update.any')) {
            return true;
        }

        if ($user->hasPermission('staff.update.own')) {
            return $user->id === $model->id;
        }

        return false;
    }

    /**
     * Determine whether the user can delete a specific staff member.
     */
    public function delete(User $user, User $model): bool
    {
        if ($user->hasPermission('staff.delete.any')) {
            return true;
        }

        if ($user->hasPermission('staff.delete.own')) {
            return $user->id !== $model->id;
        }

        return false;
    }
}