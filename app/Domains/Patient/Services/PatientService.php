<?php

namespace App\Domains\Patient\Services;

use App\Domains\Auth\Models\User;
use App\Domains\Auth\Repositories\AuthRepository;
use App\Domains\Department\Models\Department;
use App\Domains\Department\Repositories\DepartmentRepository;
use App\Domains\Patient\Models\Patient;
use App\Domains\Patient\Models\Vital;
use App\Domains\Patient\Repositories\PatientRepository;
use DomainException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class PatientService
{
    public function __construct(protected PatientRepository $repository, protected DepartmentRepository $departmentRepository, protected AuthRepository $authRepository) {}


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

    public function getPatientTimeline(int $patientId): Collection
    {
        $user = auth()->user();

        $patient = $this->repository->findOrFail($patientId);

        if (!$patient) {
            abort(404);
        }

        // Role-based access control
        if ($user->hasRole(['super_admin', 'hospital_admin'])) {
            // full access
        } elseif ($user->hasPermission('patient.view.department')) {
            if (!$user->department_id || $patient->department_id !== $user->department_id) {
                abort(403);
            }
        } elseif ($user->hasPermissionTo('patient.view.own')) {
            if ($patient->doctor_id !== $user->id) {
                abort(403);
            }
        } else {
            abort(403);
        }

        $activities = $this->repository->getPatientActivities($patientId);

        return $activities
            ->map(function ($activity) {

                $localTime = $activity->created_at->timezone('Asia/Kabul');

                $activity->time_formatted = $localTime->format('h:i A');
                $activity->date_formatted = $localTime->format('Y/m/d');

                if ($activity->description === 'updated' && isset($activity->changes['attributes'])) {

                    $changes = [];

                    foreach ($activity->changes['attributes'] as $key => $value) {

                        if (in_array($key, ['updated_at', 'id'])) continue;

                        $oldValue = $activity->changes['old'][$key] ?? null;
                        if ($oldValue == $value) continue;

                        $changes[] = [
                            'label' => str_replace('_', ' ', $key),
                            'old'   => $this->getHumanValue($key, $oldValue),
                            'new'   => $this->getHumanValue($key, $value),
                        ];
                    }

                    $activity->custom_changes = $changes;
                }

                return $activity;
            })
            ->reject(fn($a) => $a->description === 'updated' && empty($a->custom_changes));
    }

    protected function getHumanValue(string $key, $value): string
    {
        if ($value === null || $value === '') return 'N/A';

        return match ($key) {
            'doctor_id' => User::find($value)?->name ?? 'Deleted User',
            'department_id' => Department::find($value)?->name ?? 'Deleted Dept',
            'status', 'gender' => str($value)->headline(),
            default => (string) $value,
        };
    }

    public function getActiveDepartments()
    {
        return $this->departmentRepository->getActive();
    }

    public function getDoctorsByDepartment(?int $departmentId = null)
    {
        $user = auth()->user();

        // Role / Department-level check
        if ($user->hasRole(['super_admin', 'hospital_admin'])) {
            // full access
            return $this->authRepository->getDoctors(departmentId: $departmentId);
        } elseif ($user->hasPermissionTo('patient.view.department')) {
            $departmentId = $user->department_id;
            return $this->authRepository->getDoctors(departmentId: $departmentId);
        } elseif ($user->hasPermissionTo('patient.view.own')) {
            return $this->authRepository->getDoctors(departmentId: $user->department_id)
                ->where('id', $user->id);
        } else {
            abort(403);
        }
    }

    public function getPatientVitals(Patient $patient, int $perPage = 10)
    {
        $user = auth()->user();

        // Role / Department check
        if ($user->hasRole(['super_admin', 'hospital_admin'])) {
            // full access
        } elseif ($user->hasPermissionTo('patient.view.department')) {
            if ($patient->department_id !== $user->department_id) {
                abort(403);
            }
        } elseif ($user->hasPermissionTo('patient.view.own')) {
            if ($patient->doctor_id !== $user->id) {
                abort(403);
            }
        } else {
            abort(403);
        }

        return $this->repository->getPatientVitals($patient->id, $perPage);
    }
}
