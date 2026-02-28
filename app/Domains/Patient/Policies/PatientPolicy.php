<?php

namespace App\Domains\Patient\Policies;

use App\Domains\Auth\Models\User;
use App\Domains\Patient\Models\Patient;

class PatientPolicy
{
    /**
     * Global bypass for super administrators and block inactive users.
     * Super admins always bypass permissions. Inactive users always blocked.
     */
    public function before(User $user, string $ability): ?bool
    {
        // Block inactive users globally
        if (!$user->is_active) {
            return false;
        }

        // Super admin bypass
        if ($user->hasPermission('super_admin')) {
            return true;
        }

        return null;
    }

    /**
     * Determine whether the user can view the patient list.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('patient.view');
    }

    /**
     * Determine whether the user can view a specific patient.
     * Access depends on permission and contextual assignment (doctor or department).
     */
    public function view(User $user, Patient $patient): bool
    {
        if (!$user->hasPermission('patient.view')) {
            return false;
        }

        // Admin/reception can view all
        if ($user->hasPermission('patient.view.all')) {
            return true;
        }

        // Doctor can view own patients
        if ($user->hasPermission('patient.view.own')) {
            return (int) $user->id === (int) $patient->doctor_id;
        }

        // Nurse can view patients in own department
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
     * Determine whether the user can record vitals for a patient.
     */
    public function recordVitals(User $user, Patient $patient): bool
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
     * Determine whether the user can view the patient's timeline.
     */
    public function viewTimeline(User $user, Patient $patient): bool
    {
        return $this->view($user, $patient);
    }

    /**
     * Determine whether the user can restore a soft-deleted patient.
     */
    public function restore(User $user, Patient $patient): bool
    {
        return $user->hasPermission('patient.restore');
    }
}
