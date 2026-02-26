<?php

namespace App\Domains\Patient\Services;

use App\Domains\Patient\Models\Patient;
use App\Domains\Patient\Models\Vital;
use App\Domains\Patient\Repositories\PatientRepository;
use Illuminate\Support\Facades\DB;

class PatientService
{
    public function __construct(protected PatientRepository $repository) {}

    /**
     * Create a new patient record with a unique code
     */
    public function create(array $data): Patient
    {
        return DB::transaction(function () use ($data) {
            if ($this->repository->existsByNationalId($data['national_id'] ?? '')) {
                throw new \DomainException('this national ID already registered in system.');
            }

            $data['patient_code'] = $this->generatePatientCode();
            return $this->repository->create($data);
        });
    }

    /**
     * Update existing patient information
     */
    public function update(Patient $patient, array $data): bool
    {
        return DB::transaction(function () use ($patient, $data) {
            if (isset($data['national_id']) && $this->repository->existsByNationalId($data['national_id'], $patient->id)) {
                throw new \DomainException('code belongs to another patient.');
            }
            return $this->repository->update($patient, $data);
        });
    }

    /**
     * Soft delete a patient and set status to inactive
     */
    public function delete(Patient $patient): void
    {
        DB::transaction(function () use ($patient) {
            $patient->update(['status' => 'inactive']);
            $patient->delete();
        });
    }

    /**
     * Restore a soft-deleted patient
     */
    public function restore(int $id): Patient
    {
        return $this->repository->restore($id);
    }

    /**
     * Generate a unique patient code (Format: PT-YYYY-000001)
     */
    protected function generatePatientCode(): string
    {
        $year = now()->year;

        $lastPatient = Patient::withTrashed()
            ->whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();

        $nextNumber = 1;
        if ($lastPatient && $lastPatient->patient_code) {
            $lastNumber = (int) substr($lastPatient->patient_code, -6);
            $nextNumber = $lastNumber + 1;
        }

        return sprintf('PT-%s-%06d', $year, $nextNumber);
    }

    /**
     * Record new vital signs for a patient
     */
    public function recordVitals(Patient $patient, array $data): Vital
    {
        return DB::transaction(function () use ($patient, $data) {
            $data['user_id'] = auth()->id();
            return $this->repository->addVitals($patient, $data);
        });
    }

    /**
     * Get the latest vitals for all patients in the user's department
     */
    public function getDepartmentVitals()
    {
        $user = auth()->user();

        return Patient::where('department_id', $user->department_id)
            ->where('status', 'active')
            ->with(['latestVitals', 'doctor'])
            ->get()
            ->filter(function ($patient) {
                return $patient->latestVitals !== null;
            });
    }
}
