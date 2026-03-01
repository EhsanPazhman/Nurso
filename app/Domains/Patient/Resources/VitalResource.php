<?php

namespace App\Domains\Patient\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VitalResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'          => $this->id,
            'weight'      => $this->weight,
            'temperature' => $this->temperature,
            'bp'          => ($this->systolic && $this->diastolic) ? "{$this->systolic}/{$this->diastolic}" : null,
            'pulse'       => $this->pulse_rate,
            'respiratory_rate' => $this->respiratory_rate,
            'spo2'        => $this->spo2,
            'nursing_note' => $this->nursing_note,
            'temperature_status' => $this->temperature_status,
            'temperature_color'  => $this->temperature_color,
            'spo2_status'        => $this->spo2_status,
            'spo2_color'         => $this->spo2_color,
            'recorded_by' => $this->user->name ?? null,
            'recorded_at' => $this->recorded_at->toDateTimeString(),
        ];
    }
}
