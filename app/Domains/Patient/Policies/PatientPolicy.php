<?php

namespace App\Domains\Patient\Policies;

use App\Domains\Auth\Models\User;
use App\Domains\Patient\Models\Patient;

class PatientPolicy
{
    /**
     * Bypass all checks for Super Admin
     */
    public function before(User $user)
    {
        if ($user->hasRole('super_admin')) {
            return true;
        }
    }

    /**
     * Determine if user can view the patient registry list or specific file
     */
    public function view(User $user, Patient $patient)
    {
        if (!$user->can('patient.view')) return false;

        // Admins and Receptionists have full read access
        if ($user->hasRole(['hospital_admin', 'reception'])) {
            return true;
        }

        // Doctors see only their assigned patients
        if ($user->hasRole('doctor')) {
            return $user->id === $patient->doctor_id;
        }

        // Nurses see patients within their assigned department
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
