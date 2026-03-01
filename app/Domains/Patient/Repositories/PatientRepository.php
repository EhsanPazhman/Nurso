<?php

namespace App\Domains\Patient\Repositories;

use App\Domains\Patient\Models\Patient;
use App\Domains\Patient\Models\Vital;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PatientRepository
{
    public function __construct(protected Patient $model) {}

    public function paginate(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        return $this->model::query()
            ->orderByRaw("CASE 
                WHEN status = 'active' THEN 1 
                WHEN status = 'inactive' THEN 2 
                WHEN status = 'deceased' THEN 3 
                ELSE 4 END")
            ->orderBy('updated_at', 'desc')
            ->when($filters['search'] ?? null, fn($q, $s) => $q->where(function ($q2) use ($s) {
                $q2->where('first_name', 'like', "%{$s}%")
                    ->orWhere('last_name', 'like', "%{$s}%")
                    ->orWhere('patient_code', 'like', "%{$s}%")
                    ->orWhere('phone', 'like', "%{$s}%");
            }))
            ->when($filters['status'] ?? null, fn($q, $status) => $q->where('status', $status))
            ->when($filters['only_trashed'] ?? false, fn($q) => $q->onlyTrashed())
            ->with(['department', 'doctor'])
            ->paginate($perPage);
    }

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
        return $this->model::create($data);
    }

    public function update(Patient $patient, array $data): bool
    {
        return $patient->update($data);
    }

    public function restore(int $id): Patient
    {
        $patient = $this->model::withTrashed()->findOrFail($id);
        $patient->restore();
        $patient->update(['status' => 'active']);
        return $patient;
    }

    public function existsByNationalId(string $nationalId, ?int $exceptId = null): bool
    {
        return $this->model::where('national_id', $nationalId)
            ->when($exceptId, fn($q) => $q->where('id', '!=', $exceptId))
            ->exists();
    }

    public function addVitals(Patient $patient, array $data): Vital
    {
        return $patient->vitals()->create($data);
    }
}