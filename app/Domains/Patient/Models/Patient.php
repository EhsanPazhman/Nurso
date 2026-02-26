<?php

namespace App\Domains\Patient\Models;

use App\Domains\Auth\Models\User;
use App\Domains\Department\Models\Department;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Patient extends Model
{
    use SoftDeletes, LogsActivity;

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
        'doctor_id'     => 'integer',
        'created_by'    => 'integer',
        'updated_by'    => 'integer',
    ];

    /**
     * Auto-assign user IDs during creation and update
     */
    protected static function booted(): void
    {
        static::creating(function ($patient) {
            $patient->created_by = auth()->id();
        });

        static::updating(function ($patient) {
            $patient->updated_by = auth()->id();
        });
    }

    /**
     * Activity log configuration
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'first_name',
                'last_name',
                'status',
                'doctor_id',
                'department_id',
                'phone',
                'national_id'
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('patient_clinical_audit');
    }

    /* =========================
     |  Scopes
     | ========================= */

    public function scopeActive(Builder $query): void
    {
        $query->where('status', 'active');
    }

    public function scopeSearch(Builder $query, ?string $term): void
    {
        if ($term) {
            $query->where(function ($inner) use ($term) {
                $inner->where('first_name', 'like', "%{$term}%")
                    ->orWhere('last_name', 'like', "%{$term}%")
                    ->orWhere('patient_code', 'like', "%{$term}%")
                    ->orWhere('phone', 'like', "%{$term}%")
                    ->orWhere('national_id', 'like', "%{$term}%");
            });
        }
    }

    /* =========================
     |  Accessors & Relations
     | ========================= */

    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    public function getAgeAttribute(): ?int
    {
        return $this->date_of_birth ? $this->date_of_birth->age : null;
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function vitals(): HasMany
    {
        return $this->hasMany(Vital::class);
    }

    public function latestVitals(): HasOne
    {
        return $this->hasOne(Vital::class)->latestOfMany();
    }
}
