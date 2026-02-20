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
    ];

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
}
