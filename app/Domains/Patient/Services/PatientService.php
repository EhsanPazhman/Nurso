<?php

namespace App\Domains\Patient\Services;

use App\Domains\Patient\Models\Patient;
use App\Domains\Patient\Models\Vital;
use App\Domains\Patient\Repositories\PatientRepository;
use Illuminate\Support\Facades\DB;
use DomainException;

class PatientService
{
    public function __construct(protected PatientRepository $repository) {}

    public function create(array $data): Patient
    {
        return DB::transaction(function () use ($data) {
            if (!empty($data['national_id']) && $this->repository->existsByNationalId($data['national_id'])) {
                throw new DomainException('National ID already exists.');
            }

            $data['patient_code'] = $this->generatePatientCode();
            return $this->repository->create($data);
        });
    }

    public function update(Patient $patient, array $data): bool
    {
        return DB::transaction(function () use ($patient, $data) {
            if (!empty($data['national_id']) && $this->repository->existsByNationalId($data['national_id'], $patient->id)) {
                throw new DomainException('National ID belongs to another patient.');
            }
            return $this->repository->update($patient, $data);
        });
    }

    public function delete(Patient $patient): void
    {
        DB::transaction(function () use ($patient) {
            $patient->update(['status' => 'inactive']);
            $patient->delete();
        });
    }

    public function restore(int $id): Patient
    {
        return $this->repository->restore($id);
    }

    protected function generatePatientCode(): string
    {
        $year = now()->year;
        $lastPatient = Patient::withTrashed()
            ->whereYear('created_at', $year)
            ->orderByDesc('id')
            ->first();

        $nextNumber = 1;
        if ($lastPatient?->patient_code) {
            $lastNumber = (int) substr($lastPatient->patient_code, -6);
            $nextNumber = $lastNumber + 1;
        }

        return sprintf('PT-%s-%06d', $year, $nextNumber);
    }

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

        return Vital::with(['patient.department', 'user'])
            ->whereHas('patient', function ($q) use ($user) {
                $q->where('status', 'active');
                if (!$user->hasRole(['super_admin', 'hospital_admin'])) {
                    $q->where('department_id', $user->department_id);
                }
            })
            ->latest('recorded_at')
            ->paginate($perPage);
    }
}