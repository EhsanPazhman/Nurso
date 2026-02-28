<?php

namespace App\Domains\Auth\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name',
        'label',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function permissions()
    {
        // Eager loading optimization
        return $this->belongsToMany(Permission::class)->withTimestamps();
    }
}
