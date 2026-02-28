<?php

namespace App\Domains\Patient\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

class PatientVitalsRequest extends FormRequest
{
    public function authorize(): bool
    {
        $patient = $this->route('patient');
        return $patient && $this->user()->can('recordVitals', $patient);
    }

    public function rules(): array
    {
        $maxDate = Carbon::now('Asia/Kabul')->addMinutes(2)->format('Y-m-d H:i:s');

        return [
            'systolic'         => 'required|integer|between:40,250',
            'diastolic'        => 'required|integer|between:20,160',
            'temperature'      => 'nullable|numeric|between:30,45',
            'pulse_rate'       => 'required|integer|between:20,250',
            'spo2'             => 'required|integer|between:40,100',
            'respiratory_rate' => 'nullable|integer|between:5,60',
            'weight'           => 'nullable|numeric|between:0.5,600',
            'nursing_note'     => 'required|string|max:1000',
            'recorded_at'      => "required|date|before_or_equal:$maxDate",
        ];
    }

    public function messages(): array
    {
        return [
            'temperature.between' => 'Body temperature must be between 30°C and 45°C.',
            'spo2.between'        => 'Oxygen saturation must be between 40% and 100%.',
            'recorded_at.before_or_equal' => 'Recording time cannot be in the future.',
        ];
    }
}
