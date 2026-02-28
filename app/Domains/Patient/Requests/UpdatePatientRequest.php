<?php

namespace App\Domains\Patient\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePatientRequest extends FormRequest
{
    public function authorize(): bool
    {
        $patient = $this->route('patient');
        return $patient && $this->user()->can('update', $patient);
    }

    public function rules(): array
    {
        $patient = $this->route('patient');

        return [
            'first_name'      => 'sometimes|required|string|max:100',
            'last_name'       => 'sometimes|required|string|max:100',
            'father_name'     => 'nullable|string|max:100',
            'gender'          => 'sometimes|required|in:male,female',
            'date_of_birth'   => 'nullable|date|before:today',
            'phone'           => 'nullable|string|max:20',
            'secondary_phone' => 'nullable|string|max:20',
            'national_id'     => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('patients', 'national_id')->ignore($patient->id),
            ],
            'address'         => 'nullable|string|max:500',
            'status'          => 'sometimes|required|in:active,inactive,deceased',
            'department_id'   => 'sometimes|required|exists:departments,id',
            'doctor_id'       => 'nullable|exists:users,id',
        ];
    }
}
