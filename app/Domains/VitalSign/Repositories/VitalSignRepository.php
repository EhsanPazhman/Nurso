<?php

namespace App\Domains\VitalSign\Repositories;

use App\Domains\Patient\Models\Patient;
use App\Domains\Staff\Models\User;
use App\Domains\VitalSign\Models\Vital;

class VitalSignRepository
{

    public function addVitals(Patient $patient, array $data): Vital
    {
        return $patient->vitals()->create($data);
    }

    public function getPatientVitals(int $patientId, int $perPage = 10)
    {
        return Vital::where('patient_id', $patientId)
            ->with('user')
            ->latest('recorded_at')
            ->paginate($perPage);
    }

    public function getDepartmentVitals(?int $departmentId, User $user, int $perPage)
    {
        $query = Vital::query()
            ->with(['patient.department', 'user'])
            ->whereHas('patient', function ($q) use ($departmentId, $user) {

                $q->where('status', 'active');

                if ($user->hasPermission('patient.view.any')) {
                    return;
                }

                if ($user->hasPermission('patient.view.department')) {
                    $q->where('department_id', $departmentId);
                    return;
                }

                if ($user->hasPermission('patient.view.own')) {
                    $q->where('doctor_id', $user->id);
                    return;
                }
            });

        return $query
            ->latest('recorded_at')
            ->paginate($perPage);
    }
}
