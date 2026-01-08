<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vital extends Model
{
    protected $fillable = [
        'patient_id',
        'temperature',
        'heart_rate',
        'respiratory_rate',
        'blood_pressure_systolic',
        'blood_pressure_diastolic',
        'oxygen_saturation'
    ];
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
