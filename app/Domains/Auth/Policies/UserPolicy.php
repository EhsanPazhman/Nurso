<?php

namespace App\Policies;

use App\Domains\Auth\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine if the user can view the staff list.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['super_admin', 'hospital_admin']);
    }

    /**
     * Determine if the user can update a staff member.
     */
    public function update(User $user): bool
    {
        return $user->hasRole(['super_admin', 'hospital_admin']);
    }

    /**
     * Determine if the user can delete a staff member.
     */
    public function delete(User $user, User $model): bool
    {
        // Prevent self-deletion even for admins
        if ($user->id === $model->id) return false;

        return $user->hasRole(['super_admin', 'hospital_admin']);
    }
}
