<?php

namespace App\Domains\Patient\Repositories;

use App\Domains\Patient\Models\Patient;
use App\Domains\Patient\Models\Vital;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PatientRepository
{
    public function __construct(protected Patient $model) {}

    /**
     * Paginate patients with filters and role-based access control
     */
    public function paginate(int $perPage = 10, array $filters = []): LengthAwarePaginator
    {
        $user = auth()->user();

        return $this->model::query()
            ->when($user->hasRole('doctor'), function ($q) use ($user) {
                return $q->where('doctor_id', $user->id);
            })
            ->when($user->hasRole('nurse'), function ($q) use ($user) {
                return $q->where('department_id', $user->department_id);
            })
            ->when($filters['search'] ?? null, function ($q, $term) {
                return $q->search($term);
            })
            ->when($filters['status'] ?? null, function ($q, $status) {
                return $q->where('status', $status);
            })
            ->when($filters['only_trashed'] ?? false, function ($q) {
                return $q->onlyTrashed();
            })
            ->with(['department', 'doctor'])
            ->latest()
            ->paginate($perPage);
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
            ->when($exceptId, function ($q) use ($exceptId) {
                return $q->where('id', '!=', $exceptId);
            })
            ->exists();
    }

    public function addVitals(Patient $patient, array $data): Vital
    {
        return $patient->vitals()->create($data);
    }

    /**
     * Get the total count of active patients.
     */
    public function getTotalCount(): int
    {
        return $this->model::where('status', 'active')->count();
    }

    /**
     * Get the count of patients admitted today.
     */
    public function getTodayAdmissionsCount(): int
    {
        return $this->model::whereDate('created_at', now()->today())->count();
    }

    /**
     * Get recent patients for the dashboard with role-based filtering.
     */
    public function getRecent(int $limit = 6)
    {
        $user = auth()->user();

        return $this->model::query()
            ->when($user->hasRole('doctor'), function ($q) use ($user) {
                return $q->where('doctor_id', $user->id);
            })
            ->when($user->hasRole('nurse'), function ($q) use ($user) {
                return $q->where('department_id', $user->department_id);
            })
            ->with(['department', 'doctor'])
            ->latest()
            ->limit($limit)
            ->get();
    }
}
