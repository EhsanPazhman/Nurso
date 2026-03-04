<?php

namespace App\Domains\Staff\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Domains\Auth\Models\Role;
use App\Domains\Patient\Models\Patient;
use App\Domains\Department\Models\Department;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, SoftDeletes, LogsActivity;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'department_id',
        'is_active',
        'created_by',
        'updated_by'
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Auto-assign creator/updater IDs
     */
    protected static function booted()
    {
        static::creating(function ($user) {
            if (auth()->check()) $user->created_by = auth()->id();
        });

        static::updating(function ($user) {
            if (auth()->check()) $user->updated_by = auth()->id();
        });
    }

    /**
     * Activity log configuration
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('user_audit')
            ->setDescriptionForEvent(fn(string $eventName) => "User record $eventName");
    }

    // ---------------- Relations ----------------

    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function patients()
    {
        return $this->hasMany(Patient::class, 'doctor_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by')->withTrashed();
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by')->withTrashed();
    }

    // ---------------- Authorization Logic ----------------

    public function setPasswordAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['password'] = bcrypt($value);
        }
    }

    public function getCachedPermissions()
    {
        return Cache::remember(
            "user_permissions_{$this->id}",
            now()->addMinutes(10),
            function () {
                return $this->roles()
                    ->with('permissions:id,name')
                    ->get()
                    ->pluck('permissions')
                    ->flatten()
                    ->pluck('name')
                    ->unique()
                    ->toArray();
            }
        );
    }

    public function hasRole($role): bool
    {
        $roles = $this->roles->pluck('name')->toArray();

        if (is_array($role)) {
            return count(array_intersect($roles, $role)) > 0;
        }

        return in_array($role, $roles);
    }

    public function hasPermission(string $permission): bool
    {
        return in_array($permission, $this->getCachedPermissions());
    }

    public function scopeActive(Builder $query)
    {
        return $query->where('is_active', true);
    }
}
