<?php

namespace App\Domains\VitalSign\Services;

use App\Domains\Patient\Models\Patient;
use App\Domains\VitalSign\Models\Vital;
use App\Domains\VitalSign\Repositories\VitalSignRepository;
use Illuminate\Support\Facades\DB;

class VitalSignService
{

    public function __construct(protected VitalSignRepository $repository) {}


    /* =========================
     |  Vitals
     ==========================*/

    public function recordVitals(Patient $patient, array $data): Vital
    {
        return DB::transaction(function () use ($patient, $data) {

            $data['user_id'] = auth()->id();

            return $this->repository->addVitals($patient, $data);
        });
    }

    public function getDepartmentVitals(int $perPage = 15)
    {
        $user = auth()->user();

        $isAdmin = $user->hasRole(['super_admin', 'hospital_admin']);
        if (!$isAdmin && !$user->department_id) {
            throw new \DomainException('User is not assigned to any department.');
        }
        return $this->repository->getDepartmentVitals(
            $user->department_id,
            $user,
            $perPage
        );
    }
}
