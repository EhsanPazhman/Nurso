<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = ['name', 'age', 'gender', 'bed_number', 'status'];
    public function vitals()
    {
        return $this->hasMany(Vital::class);
    }
}
