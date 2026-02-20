<?php

namespace App\Domains\Patient\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatientVitalsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'systolic'         => 'nullable|integer|between:40,250',
            'diastolic'        => 'nullable|integer|between:20,160',
            'temperature'      => 'nullable|numeric|between:30,45',
            'pulse_rate'       => 'nullable|integer|between:20,250',
            'spo2'             => 'nullable|integer|between:40,100',
            'respiratory_rate' => 'nullable|integer|between:5,60',
            'weight'           => 'nullable|numeric|between:0.5,600',
            'nursing_note'     => 'nullable|string|max:1000',
            'recorded_at'      => 'required|date|before_or_equal:now',
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
