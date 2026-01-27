<?php

namespace App\Domains\Patient\Requests;

use App\Domains\Patient\Models\Patient;
use Illuminate\Foundation\Http\FormRequest;

class StorePatientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->guard->check()
            && auth()->guard->user()->can('create', Patient::class);
    }


    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:100',
            'last_name'  => 'required|string|max:100',
            'father_name' => 'nullable|string|max:100',
            'gender'     => 'required|in:male,female',
            'date_of_birth' => 'nullable|date',
            'phone' => 'nullable|string|max:20',
            'secondary_phone' => 'nullable|string|max:20',
            'national_id' => 'nullable|string|max:50|unique:patients,national_id',
            'address' => 'nullable|string',
        ];
    }
}
