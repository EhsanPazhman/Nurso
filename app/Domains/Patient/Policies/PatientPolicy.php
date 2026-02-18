<?php

namespace App\Domains\Patient\Policies;

use App\Domains\Auth\Models\User;
use App\Domains\Patient\Models\Patient;

class PatientPolicy
{
    public function viewAny(User $user)
    {
        return $user->hasPermission('patient.view');
    }

    /**
     * Determine if user can view a SPECIFIC patient profile.
     */
    public function view(User $user, Patient $patient)
    {
        if (!$user->hasPermission('patient.view')) return false;

        if ($user->hasRole(['hospital_admin', 'reception'])) return true;

        if ($user->hasRole('doctor')) {
            return $user->id === $patient->doctor_id;
        }

        if ($user->hasRole('nurse')) {
            return $user->department_id === $patient->department_id;
        }

        return false;
    }

    /**
     * Only specialized roles can register new patients
     */
    public function create(User $user)
    {
        return $user->can('patient.create') && $user->hasRole(['reception', 'hospital_admin']);
    }

    /**
     * Determine who can edit identity/base information of a patient
     */
    public function update(User $user, Patient $patient)
    {
        if (!$user->can('patient.update')) return false;

        // Nurses are strictly forbidden from editing identity records
        if ($user->hasRole('nurse')) return false;

        // Doctors can update clinical context of THEIR patients
        if ($user->hasRole('doctor')) {
            return $user->id === $patient->doctor_id;
        }

        // Hospital Admins and Receptionists handle identity/contact updates
        return $user->hasRole(['hospital_admin', 'reception']);
    }

    /**
     * Deletion is a high-level administrative task
     */
    public function delete(User $user, Patient $patient)
    {
        return $user->can('patient.delete') && $user->hasRole('hospital_admin');
    }
}
