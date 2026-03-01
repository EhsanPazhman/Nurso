<?php

namespace App\Domains\Patient\Resources;

use App\Domains\Patient\Resources\VitalResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'           => $this->id,
            'patient_code' => $this->patient_code,
            'first_name'   => $this->first_name,
            'last_name'    => $this->last_name,
            'phone'        => $this->phone,
            'status'       => $this->status,
            'department'   => $this->whenLoaded('department'),
            'doctor'       => $this->whenLoaded('doctor'),
            'vitals'       => VitalResource::collection($this->whenLoaded('vitals')),
            'created_at'   => $this->created_at->toDateTimeString(),
        ];
    }
}
