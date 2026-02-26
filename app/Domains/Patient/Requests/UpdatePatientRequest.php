<?php

namespace App\Domains\Patient\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePatientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $patient = $this->route('patient');
        return auth()->check() && $patient && auth()->user()->can('update', $patient);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        // Get the patient ID from the route to ignore it in unique validation
        $patient = $this->route('patient');
        $patientId = is_object($patient) ? $patient->id : $patient;

        return [
            'first_name'      => 'sometimes|required|string|max:100',
            'last_name'       => 'sometimes|required|string|max:100',
            'father_name'     => 'nullable|string|max:100',
            'gender'          => 'sometimes|required|in:male,female',
            'date_of_birth'   => 'nullable|date|before:today',
            'phone'           => 'nullable|string|max:20',
            'secondary_phone' => 'nullable|string|max:20',
            'national_id'     => "nullable|string|max:50|unique:patients,national_id,{$patientId}",
            'address'         => 'nullable|string|max:500',
            'status'          => 'sometimes|required|in:active,inactive,deceased',
            'department_id'   => 'sometimes|required|exists:departments,id',
            'doctor_id'       => 'nullable|exists:users,id',
        ];
    }
}
