<?php

namespace App\Domains\Patient\Repositories;

use App\Domains\Auth\Models\User;
use App\Domains\Patient\Models\Patient;
use App\Domains\Patient\Models\Vital;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PatientRepository
{
    public function __construct(protected Patient $model) {}

    /* =========================
     |  Query Methods
     ==========================*/

    public function findOrFail(int $id): Patient
    {
        return $this->model->newQuery()->findOrFail($id);
    }

    public function findWithTrashedOrFail(int $id): Patient
    {
        return $this->model->newQuery()->withTrashed()->findOrFail($id);
    }

    public function paginate(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        return $this->model->newQuery()
            ->orderByRaw("
                CASE 
                    WHEN status = 'active' THEN 1 
                    WHEN status = 'inactive' THEN 2 
                    WHEN status = 'deceased' THEN 3 
                    ELSE 4 
                END
            ")
            ->orderBy('updated_at', 'desc')
            ->when($filters['search'] ?? null, function ($q, $s) {
                $q->where(function ($q2) use ($s) {
                    $q2->where('first_name', 'like', "%{$s}%")
                        ->orWhere('last_name', 'like', "%{$s}%")
                        ->orWhere('patient_code', 'like', "%{$s}%")
                        ->orWhere('phone', 'like', "%{$s}%");
                });
            })
            ->when($filters['status'] ?? null, fn($q, $status) => $q->where('status', $status))
            ->when($filters['only_trashed'] ?? false, fn($q) => $q->onlyTrashed())
            ->with(['department', 'doctor'])
            ->paginate($perPage);
    }

    public function getLastPatientOfYear(int $year): ?Patient
    {
        return $this->model->newQuery()
            ->withTrashed()
            ->whereYear('created_at', $year)
            ->orderByDesc('id')
            ->first();
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

    /* =========================
     |  Write Methods
     ==========================*/

    public function getTotalCount(): int
    {
        return $this->model::where('status', 'active')->count();
    }

    public function getTodayAdmissionsCount(): int
    {
        return $this->model::whereDate('created_at', now()->today())->count();
    }

    public function getRecent(int $limit = 6)
    {
        return $this->model::with(['department', 'doctor'])
            ->where('status', 'active')
            ->latest()
            ->limit($limit)
            ->get();
    }

    public function create(array $data): Patient
    {
        return $this->model->create($data);
    }

    public function update(Patient $patient, array $data): bool
    {
        return $patient->update($data);
    }

    public function softDelete(Patient $patient): void
    {
        $patient->delete();
    }

    public function restore(Patient $patient): void
    {
        $patient->restore();
    }

    public function existsByNationalId(string $nationalId, ?int $exceptId = null): bool
    {
        return $this->model->newQuery()
            ->where('national_id', $nationalId)
            ->when($exceptId, fn($q) => $q->where('id', '!=', $exceptId))
            ->exists();
    }

    public function addVitals(Patient $patient, array $data): Vital
    {
        return $patient->vitals()->create($data);
    }
}
