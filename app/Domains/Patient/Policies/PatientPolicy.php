<?php

namespace App\Domains\Patient\Policies;

use App\Domains\Staff\Models\User;
use App\Domains\Patient\Models\Patient;

class PatientPolicy
{
    /**
     * Global bypass for super administrators and block inactive users.
     */
    public function before(User $user, string $ability): ?bool
    {
        // Block inactive users globally
        if (!$user->is_active) {
            return false;
        }

        // Super admin bypass (aligned with seeder)
        if ($user->hasPermission('system.super')) {
            return true;
        }

        return null;
    }

    /**
     * Determine whether the user can view the patient list.
     */
    public function viewAny(User $user): bool
    {
        return
            $user->hasPermission('patient.view.any') ||
            $user->hasPermission('patient.view.own') ||
            $user->hasPermission('patient.view.department');
    }

    /**
     * Determine whether the user can view a specific patient.
     */
    public function view(User $user, Patient $patient): bool
    {
        if ($user->hasPermission('patient.view.any')) {
            return true;
        }

        if ($user->hasPermission('patient.view.own')) {
            return (int) $user->id === (int) $patient->doctor_id;
        }

        if ($user->hasPermission('patient.view.department')) {
            return (int) $user->department_id === (int) $patient->department_id;
        }

        return false;
    }

    /**
     * Determine whether the user can create a patient.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('patient.create');
    }

    /**
     * Determine whether the user can update a specific patient.
     */
    public function update(User $user, Patient $patient): bool
    {
        if ($user->hasPermission('patient.update.any')) {
            return true;
        }

        if ($user->hasPermission('patient.update.own')) {
            return (int) $user->id === (int) $patient->doctor_id;
        }

        return false;
    }

    /**
     * Determine whether the user can delete a patient.
     */
    public function delete(User $user, Patient $patient): bool
    {
        return $user->hasPermission('patient.delete');
    }

    /**
     * Determine whether the user can restore a soft-deleted patient.
     */
    public function restore(User $user, Patient $patient): bool
    {
        return $user->hasPermission('patient.restore');
    }
}
