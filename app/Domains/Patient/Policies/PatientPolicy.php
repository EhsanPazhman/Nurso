<?php

namespace App\Domains\Patient\Policies;

use App\Domains\Auth\Models\User;
use App\Domains\Patient\Models\Patient;

class PatientPolicy
{
    /**
     * Global bypass for super administrators.
     */
    public function before(User $user, string $ability): ?bool
    {
        if ($user->hasRole('super_admin')) {
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
     */
    public function view(User $user, Patient $patient): bool
    {
        if (!$user->hasPermission('patient.view')) {
            return false;
        }

        if ($user->hasRole(['hospital_admin', 'reception'])) {
            return true;
        }

        if ($user->hasRole('doctor')) {
            return $user->id === $patient->doctor_id;
        }

        if ($user->hasRole('nurse')) {
            return $user->department_id === $patient->department_id;
        }

        return false;
    }

    /**
     * Determine whether the user can create a patient.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('patient.create')
            && $user->hasRole(['hospital_admin', 'reception']);
    }

    /**
     * Determine whether the user can update a specific patient.
     */
    public function update(User $user, Patient $patient): bool
    {
        if (!$user->hasPermission('patient.update')) {
            return false;
        }

        if ($user->hasRole('doctor')) {
            return $user->id === $patient->doctor_id;
        }

        if ($user->hasRole('nurse')) {
            return false;
        }

        return true;
    }

    /**
     * Determine whether the user can delete a patient.
     */
    public function delete(User $user, Patient $patient): bool
    {
        return $user->hasPermission('patient.delete')
            && $user->hasRole('hospital_admin');
    }

    /**
     * Determine whether the user can record vitals for a patient.
     */
    public function recordVitals(User $user, Patient $patient): bool
    {
        if (!$user->hasPermission('patient.recordVitals')) {
            return false;
        }

        if ($user->hasRole('hospital_admin')) {
            return true;
        }

        if ($user->hasRole('doctor')) {
            return $user->id === $patient->doctor_id;
        }

        if ($user->hasRole('nurse')) {
            return $user->department_id === $patient->department_id;
        }

        return false;
    }

    /**
     * Determine whether the user can view the patient's timeline.
     */
    public function viewTimeline(User $user, Patient $patient): bool
    {
        if ($user->hasRole(['super_admin', 'hospital_admin'])) {
            return true;
        }

        if ($user->hasRole('doctor')) {
            return (int) $user->id === (int) $patient->doctor_id;
        }

        if ($user->hasRole('nurse')) {
            return (int) $user->department_id === (int) $patient->department_id;
        }

        return false;
    }
    /**
     * Determine whether the user can restore a soft-deleted patient.
     */
    public function restore(User $user, Patient $patient)
    {
        return $user->hasRole(['super_admin', 'hospital_admin']);
    }
}
