<?php

namespace App\Domains\Patient\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePatientRequest extends FormRequest
{
    public function authorize(): bool
    {
        $patient =  $this->route('patient');

        return auth()->guard->check()
            && $patient
            && auth()->guard->user()->can('update', $patient);
    }


    public function rules(): array
    {
        return [
            'first_name' => 'sometimes|required|string|max:100',
            'last_name'  => 'sometimes|required|string|max:100',
            'father_name' => 'nullable|string|max:100',
            'gender'     => 'sometimes|required|in:male,female',
            'date_of_birth' => 'nullable|date',
            'phone' => 'nullable|string|max:20',
            'secondary_phone' => 'nullable|string|max:20',
            'national_id' => 'nullable|string|max:50|unique:patients,national_id,' . $this->route('patient')->id,
            'address' => 'nullable|string',
            'status' => 'sometimes|required|in:active,inactive,deceased',
        ];
    }
}
