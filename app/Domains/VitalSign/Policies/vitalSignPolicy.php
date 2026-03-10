<?php

namespace App\Domains\VitalSign\Policies;

use App\Domains\Patient\Models\Patient;
use App\Domains\Staff\Models\User;

class VitalSignPolicy
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
     * Determine whether the user can view the vitals/timeline.
     */
    public function viewAny(User $user, Patient $patient): bool
    {
        if ($user->hasPermission('medical.vitals.any')) {
            return true;
        }

        if ($user->hasPermission('medical.vitals.own')) {
            return (int) $user->id === (int) $patient->doctor_id;
        }

        if ($user->hasPermission('medical.vitals.department')) {
            return (int) $user->department_id === (int) $patient->department_id;
        }

        return false;
    }

    /**
     * Determine whether the user can record vitals.
     */
    public function create(User $user, Patient $patient): bool
    {
        if ($user->hasPermission('medical.vitals.any')) {
            return true;
        }

        if ($user->hasPermission('medical.vitals.own')) {
            return (int) $user->id === (int) $patient->doctor_id;
        }

        if ($user->hasPermission('medical.vitals.department')) {
            return (int) $user->department_id === (int) $patient->department_id;
        }

        return false;
    }
}
