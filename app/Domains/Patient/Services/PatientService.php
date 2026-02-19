<?php

namespace App\Domains\Patient\Services;

use App\Domains\Patient\Repositories\PatientRepository;
use App\Domains\Patient\Models\Patient;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class PatientService
{
    public function __construct(
        protected PatientRepository $repository
    ) {}

    /* =========================
     |  Create Patient
     | =========================
     */
    public function create(array $data): Patient
    {
        return DB::transaction(function () use ($data) {

            if ($this->repository->existsByNationalId($data['national_id'] ?? null)) {
                throw new \DomainException('Patient with this National ID already exists.');
            }

            $data['patient_code'] = $this->generatePatientCode();

            $patient = $this->repository->create($data);

            return $patient;
        });
    }

    /* =========================
     |  Update Patient
     | =========================
     */
    public function update(Patient $patient, array $data): Patient
    {
        return DB::transaction(function () use ($patient, $data) {
            if (
                isset($data['national_id']) &&
                $data['national_id'] !== $patient->national_id &&
                $this->repository->existsByNationalId($data['national_id'])
            ) {
                throw new \DomainException('National ID already in use.');
            }
            return $this->repository->update($patient, $data);
        });
    }


    /* =========================
     |  Delete (Soft)
     | =========================
     */
    public function delete(Patient $patient): void
    {
        DB::transaction(function () use ($patient) {
            $patient->status = 'inactive';
            $patient->saveQuietly();
            $this->repository->delete($patient);
        });
    }

    /* =========================
     |  Restore
     | =========================
     */
    public function restore(int $id): Patient
    {
        $patient = $this->repository->restore($id);

        return $patient;
    }

    /* =========================
     |  Generate Patient Code
     | =========================
     */
    protected function generatePatientCode(): string
    {
        $year = now()->year;

        $lastPatient = Patient::whereYear('created_at', $year)
            ->orderByDesc('id')
            ->first();

        $nextNumber = $lastPatient
            ? ((int) substr($lastPatient->patient_code, -6)) + 1
            : 1;

        return sprintf('PT-%s-%06d', $year, $nextNumber);
    }

    public function changeStatus(Patient $patient, string $status): void
    {
        DB::transaction(function () use ($patient, $status) {
            $this->repository->updateStatus($patient, $status);
        });
    }
}
