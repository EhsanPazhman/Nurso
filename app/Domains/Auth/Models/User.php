<?php

namespace App\Domains\Auth\Models;

use App\Domains\Auth\Models\Role;
use Laravel\Sanctum\HasApiTokens;
use App\Domains\Patient\Models\Patient;
use Illuminate\Notifications\Notifiable;
use App\Domains\Department\Models\Department;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'department_id',
        'is_active',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // ---------------- Relations ----------------

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function patients()
    {
        return $this->hasMany(Patient::class, 'doctor_id');
    }

    // ---------------- Permissions Logic ----------------

    public function hasRole($role): bool
    {
        if (is_array($role)) {
            return $this->roles()->whereIn('name', $role)->exists();
        }

        return $this->roles()->where('name', $role)->exists();
    }

    public function hasPermission(string $permission): bool
    {
        return $this->roles()
            ->whereHas('permissions', function ($q) use ($permission) {
                $q->where('name', $permission);
            })
            ->exists();
    }
}
