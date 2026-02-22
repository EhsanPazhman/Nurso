<?php

namespace App\Domains\Patient\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Domains\Auth\Models\User;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Vital extends Model
{
    use SoftDeletes, LogsActivity;

    protected $fillable = [
        'patient_id',
        'user_id',
        'systolic',
        'diastolic',
        'temperature',
        'pulse_rate',
        'respiratory_rate',
        'spo2',
        'weight',
        'nursing_note',
        'recorded_at'
    ];

    protected $casts = [
        'recorded_at' => 'datetime',
        'spo2' => 'integer',
        'temperature' => 'float',
        'pulse_rate' => 'integer',
        'respiratory_rate' => 'integer',
        'systolic' => 'integer',
        'diastolic' => 'integer',
    ];
    public function getAgeAttribute()
    {
        return $this->date_of_birth?->age;
    }

    public function getTemperatureStatusAttribute()
    {
        $age = $this->patient->age ?? 30;
        $temp = $this->temperature;

        if ($age < 1) {
            $normalMin = 36.5;
            $normalMax = 37.5;
        } else {
            $normalMin = 36.5;
            $normalMax = 37.5;
        }

        if ($temp < $normalMin - 0.5 || $temp > $normalMax + 0.5) {
            return 'critical';
        }

        if ($temp < $normalMin || $temp > $normalMax) {
            return 'warning';
        }

        return 'normal';
    }

    public function getTemperatureColorAttribute()
    {
        return $this->mapStatusToColor($this->temperature_status);
    }

    public function getPulseRateStatusAttribute()
    {
        $age = $this->patient->age ?? 30;
        $pulse = $this->pulse_rate;

        if ($age < 1) {
            $normalMin = 100;
            $normalMax = 160;
        } elseif ($age < 12) {
            $normalMin = 70;
            $normalMax = 120;
        } else {
            $normalMin = 60;
            $normalMax = 100;
        }

        if ($pulse < $normalMin - 10 || $pulse > $normalMax + 10) {
            return 'critical';
        }

        if ($pulse < $normalMin || $pulse > $normalMax) {
            return 'warning';
        }

        return 'normal';
    }

    public function getPulseRateColorAttribute()
    {
        return $this->mapStatusToColor($this->pulse_rate_status);
    }

    public function getSpo2StatusAttribute()
    {
        $spo2 = $this->spo2;

        if ($spo2 < 80) {
            return 'life_threatening';
        }

        if ($spo2 < 88) {
            return 'critical';
        }

        if ($spo2 < 92) {
            return 'warning';
        }

        if ($spo2 < 95) {
            return 'borderline';
        }

        return 'normal';
    }

    public function getSpo2ColorAttribute()
    {
        return $this->mapStatusToColor($this->spo2_status);
    }

    public function getRespiratoryRateStatusAttribute()
    {
        $age = $this->patient->age ?? 30;
        $rate = $this->respiratory_rate;

        if ($age < 1) {
            $normalMin = 30;
            $normalMax = 60;
        } elseif ($age < 12) {
            $normalMin = 18;
            $normalMax = 30;
        } else {
            $normalMin = 12;
            $normalMax = 20;
        }

        if ($rate < $normalMin - 5 || $rate > $normalMax + 5) {
            return 'critical';
        }

        if ($rate < $normalMin || $rate > $normalMax) {
            return 'warning';
        }

        return 'normal';
    }

    public function getRespiratoryRateColorAttribute()
    {
        return $this->mapStatusToColor($this->respiratory_rate_status);
    }

    public function getBloodPressureStatusAttribute()
    {
        $age = $this->patient->age ?? 30;
        $sys = $this->systolic;

        if ($age < 12) {
            $normalMin = 90;
            $normalMax = 110;
        } else {
            $normalMin = 100;
            $normalMax = 130;
        }

        if ($sys < $normalMin - 10 || $sys > $normalMax + 20) {
            return 'critical';
        }

        if ($sys < $normalMin || $sys > $normalMax) {
            return 'warning';
        }

        return 'normal';
    }

    public function getBloodPressureColorAttribute()
    {
        return $this->mapStatusToColor($this->blood_pressure_status);
    }


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->useLogName('patient_clinical_audit')
            ->setDescriptionForEvent(fn(string $eventName) => "Vital signs $eventName");
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected function mapStatusToColor($status)
    {
        return match ($status) {
            'life_threatening' => 'bg-rose-700 rounded-md text-white font-bold animate-pulse',
            'critical'         => 'text-rose-600 font-bold',
            'warning'          => 'text-amber-500 font-bold',
            'borderline'       => 'text-yellow-500 font-semibold',
            default            => 'text-emerald-600 font-bold',
        };
    }
}
