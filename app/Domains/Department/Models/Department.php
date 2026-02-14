<?php

namespace App\Domains\Department\Models;

use Illuminate\Database\Eloquent\Model;
use App\Domains\Auth\Models\User;
use App\Domains\Patient\Models\Patient;

class Department extends Model
{
    protected $fillable = ['name', 'slug', 'is_active'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function patients()
    {
        return $this->hasMany(Patient::class);
    }
}
