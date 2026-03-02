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


    /* =========================
     |  Query Methods
     ==========================*/

    public function find(int $id): Patient
    {
        return $this->repository->findOrFail($id);
    }

    public function findWithTrashed(int $id): Patient
    {
        return $this->repository->findWithTrashedOrFail($id);
    }

    public function paginate(int $perPage = 15, array $filters = [])
    {
        return $this->repository->paginate($perPage, $filters);
    }

    public function getTotalCount(): int
    {
        return $this->repository->getTotalCount();
    }

    public function getTodayAdmissionsCount(): int
    {
        return $this->repository->getTodayAdmissionsCount();
    }

    public function getRecent(int $limit = 6)
    {
        return $this->repository->getRecent($limit);
    }

    /* =========================
     |  Create / Update
     ==========================*/

    public function create(array $data): Patient
    {
        return DB::transaction(function () use ($data) {

            if (
                !empty($data['national_id']) &&
                $this->repository->existsByNationalId($data['national_id'])
            ) {
                throw new DomainException('National ID already exists.');
            }

            $data['patient_code'] = $this->generatePatientCode();

            return $this->repository->create($data);
        });
    }

    public function update(Patient $patient, array $data): bool
    {
        return DB::transaction(function () use ($patient, $data) {

            if (
                !empty($data['national_id']) &&
                $this->repository->existsByNationalId($data['national_id'], $patient->id)
            ) {
                throw new DomainException('National ID belongs to another patient.');
            }

            return $this->repository->update($patient, $data);
        });
    }

    /* =========================
     |  Status / Delete
     ==========================*/

    public function changeStatus(Patient $patient, string $status): bool
    {
        return $this->repository->update($patient, ['status' => $status]);
    }

    public function delete(Patient $patient): void
    {
        DB::transaction(function () use ($patient) {

            $this->repository->update($patient, ['status' => 'inactive']);

            $this->repository->softDelete($patient);
        });
    }

    public function restore(int $id): void
    {
        $patient = $this->repository->findWithTrashedOrFail($id);

        DB::transaction(function () use ($patient) {

            $this->repository->restore($patient);

            $this->repository->update($patient, ['status' => 'active']);
        });
    }

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

    /* =========================
     |  Private
     ==========================*/

    protected function generatePatientCode(): string
    {
        $year = now()->year;

        $lastPatient = $this->repository->getLastPatientOfYear($year);

        $nextNumber = 1;

        if ($lastPatient?->patient_code) {
            $lastNumber = (int) substr($lastPatient->patient_code, -6);
            $nextNumber = $lastNumber + 1;
        }

        return sprintf('PT-%s-%06d', $year, $nextNumber);
    }
}
