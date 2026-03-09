<?php

namespace App\Domains\Patient\Repositories;

use App\Domains\Patient\Models\Patient;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Collection;

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

    /* =========================
     |  Patient Activity Log
     ==========================*/
    public function getPatientActivities(int $patientId): Collection
    {
        return Activity::where('subject_type', \App\Domains\Patient\Models\Patient::class)
            ->where('subject_id', $patientId)
            ->with('causer')
            ->latest()
            ->get();
    }
}
