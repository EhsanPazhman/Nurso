<?php

namespace App\Domains\Patient\Repositories;

use App\Domains\Patient\Models\Patient;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PatientRepository
{
    protected $model;

    public function __construct(Patient $model)
    {
        $this->model = $model;
    }

    public function paginate(int $perPage = 10, string $search = '', string $status = '', bool $onlyTrashed = false)
    {
        $query = $this->model::query();
        $user = auth()->user();

        if ($user->hasRole('doctor')) {
            $query->where('doctor_id', $user->id);
        } elseif ($user->hasRole('nurse')) {
            $query->where('department_id', $user->department_id);
        }

        if ($onlyTrashed) $query->onlyTrashed();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('father_name', 'like', "%{$search}%")
                    ->orWhere('patient_code', 'like', "%{$search}%");
            });
        }

        if ($status && !$onlyTrashed) $query->where('status', $status);

        return $query->with(['department', 'doctor'])->latest()->paginate($perPage);
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
    public function getTotalCount(): int
    {
        return Patient::count();
    }

    public function getTodayAdmissionsCount(): int
    {
        return Patient::whereDate('created_at', now()->today())->count();
    }
    public function updateStatus(Patient $patient, string $status): bool
    {
        return $patient->update(['status' => $status]);
    }
}
