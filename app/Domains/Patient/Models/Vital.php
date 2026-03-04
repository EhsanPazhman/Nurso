<?php

namespace App\Domains\Patient\Models;

use App\Domains\Staff\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

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
        'temperature' => 'float',
        'spo2'        => 'integer',
        'systolic'    => 'integer',
        'diastolic'   => 'integer',
    ];

    /**
     * Determine temperature status based on values
     */
    public function getTemperatureStatusAttribute(): string
    {
        $temp = $this->temperature;
        if ($temp < 35.0 || $temp > 39.0) return 'critical';
        if ($temp < 36.5 || $temp > 37.5) return 'warning';
        return 'normal';
    }

    /**
     * Determine SpO2 status
     */
    public function getSpo2StatusAttribute(): string
    {
        $spo2 = $this->spo2;
        if ($spo2 < 88) return 'critical';
        if ($spo2 < 94) return 'warning';
        return 'normal';
    }

    /**
     * Get CSS classes for temperature display
     */
    public function getTemperatureColorAttribute(): string
    {
        return $this->mapStatusToColor($this->temperature_status);
    }

    /**
     * Get CSS classes for SpO2 display
     */
    public function getSpo2ColorAttribute(): string
    {
        return $this->mapStatusToColor($this->spo2_status);
    }

    /**
     * Map clinical status to Tailwind CSS classes
     */
    protected function mapStatusToColor(string $status): string
    {
        return match ($status) {
            'critical' => 'text-rose-600 bg-rose-50 px-2 py-0.5 rounded font-bold animate-pulse ring-1 ring-rose-200',
            'warning'  => 'text-amber-600 bg-amber-50 px-2 py-0.5 rounded font-semibold',
            default    => 'text-emerald-600 font-medium',
        };
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->useLogName('patient_clinical_audit')
            ->setDescriptionForEvent(function (string $eventName) {
                return "Vital signs recorded: $eventName";
            });
    }
}
