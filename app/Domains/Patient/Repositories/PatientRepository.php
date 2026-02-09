<?php

namespace App\Domains\Patient\Repositories;

use App\Domains\Patient\Models\Patient;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PatientRepository
{
    public function paginate(
        int $perPage = 15,
        ?string $search = null,
        ?string $status = null
    ): LengthAwarePaginator {
        return Patient::query()
            ->search($search)
            ->when($status, fn($q) => $q->where('status', $status))
            ->latest()
            ->paginate($perPage);
    }

    public function findById(int $id): Patient
    {
        return Patient::findOrFail($id);
    }

    public function create(array $data): Patient
    {
        return Patient::create($data);
    }

    public function update(Patient $patient, array $data): Patient
    {
        $patient->update($data);

        return $patient;
    }

    public function delete(Patient $patient): void
    {
        $patient->delete();
    }

    public function restore(int $id): Patient
    {
        $patient = Patient::withTrashed()->findOrFail($id);
        $patient->restore();

        return $patient;
    }

    public function existsByNationalId(?string $nationalId): bool
    {
        if (!$nationalId) {
            return false;
        }

        return Patient::where('national_id', $nationalId)->exists();
    }
    public function getRecent(int $limit = 5)
    {
        return Patient::latest()->limit($limit)->get();
    }
}
