<?php

namespace App\Domains\Auth\Models;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
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

    // ---------------- Permissions Logic ----------------

    public function hasRole(string $role): bool
    {
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

    /**
     * Override Laravel can() to use permissions
     */
    // public function can($ability, $arguments = []): bool
    // {
    //     return $this->hasPermission($ability);
    // }
}
