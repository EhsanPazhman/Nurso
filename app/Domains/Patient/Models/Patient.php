<?php

namespace App\Domains\Patient\Models;

use id;
use App\Domains\Auth\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Domains\Department\Models\Department;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use SoftDeletes;

    protected $table = 'patients';

    protected $fillable = [
        'patient_code',
        'first_name',
        'last_name',
        'father_name',
        'gender',
        'date_of_birth',
        'phone',
        'secondary_phone',
        'national_id',
        'address',
        'status',
        'created_by',
        'updated_by',
        'department_id', 
        'doctor_id',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'department_id' => 'integer',
        'doctor_id' => 'integer',
        'deleted_at'    => 'datetime',
    ];

    /* =========================
     |  Model Boot
     | =========================
     */

    protected static function booted()
    {
        static::creating(function ($patient) {
            $patient->created_by = auth()->id();
        });

        static::updating(function ($patient) {
            $patient->updated_by = auth()->id();
        });
    }

    /* =========================
     |  Scopes
     | =========================
     */

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        if (!$term) {
            return $query;
        }

        return $query->where(function ($q) use ($term) {
            $q->where('first_name', 'like', "%{$term}%")
                ->orWhere('last_name', 'like', "%{$term}%")
                ->orWhere('patient_code', 'like', "%{$term}%")
                ->orWhere('phone', 'like', "%{$term}%");
        });
    }

    /* =========================
     |  Accessors
     | =========================
     */

    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
}
