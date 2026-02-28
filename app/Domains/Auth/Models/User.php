<?php

namespace App\Domains\Auth\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use App\Domains\Auth\Models\Role;
use App\Domains\Patient\Models\Patient;
use App\Domains\Department\Models\Department;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, SoftDeletes;

    /*
     * Mass assignable attributes.
     */
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

    /*
     * Hidden attributes for serialization.
     */
    protected $hidden = [
        'password',
    ];

    /*
     * Attribute casting.
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Automatically track creator and updater.
     * This ensures audit trail without manual assignment.
     */
    protected static function booted()
    {
        static::creating(function ($user) {
            if (auth()->check()) {
                $user->created_by = auth()->id();
            }
        });

        static::updating(function ($user) {
            if (auth()->check()) {
                $user->updated_by = auth()->id();
            }
        });
    }

    // ---------------- Relations ----------------

    /*
     * User roles (Many-to-Many).
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    /*
     * User department (Single department assignment).
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /*
     * Patients assigned to doctor.
     */
    public function patients()
    {
        return $this->hasMany(Patient::class, 'doctor_id');
    }

    /*
     * Creator relationship (with soft-deleted support).
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by')->withTrashed();
    }

    /*
     * Updater relationship (with soft-deleted support).
     */
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by')->withTrashed();
    }

    // ---------------- Authorization Logic ----------------

    /*
     * Automatically hash password when setting it.
     */
    public function setPasswordAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['password'] = bcrypt($value);
        }
    }

    /*
     * Cached user permissions.
     * Prevents multiple DB queries within the same request lifecycle.
     */
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

    /*
     * Check if user has a specific role.
     */
    public function hasRole($role): bool
    {
        $roles = $this->roles->pluck('name')->toArray();

        if (is_array($role)) {
            return count(array_intersect($roles, $role)) > 0;
        }

        return in_array($role, $roles);
    }

    /*
     * Check if user has a specific permission.
     * Uses cached permissions for performance optimization.
     */
    public function hasPermission(string $permission): bool
    {
        return in_array($permission, $this->getCachedPermissions());
    }

    /*
     * Scope to filter only active users.
     */
    public function scopeActive(Builder $query)
    {
        return $query->where('is_active', true);
    }
}
