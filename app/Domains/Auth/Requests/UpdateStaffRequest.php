<?php

namespace App\Domains\Auth\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStaffRequest extends FormRequest
{
    public function authorize(): bool
    {
        $staff = $this->route('staff');
        return $staff && $this->user()->can('update', $staff);
    }

    public function rules(): array
    {
        $staff = $this->route('staff');

        return [
            'name'          => 'required|string|max:255',
            'email'         => [
                'required',
                'email',
                Rule::unique('users')->ignore($staff->id),
            ],
            'password'      => 'nullable|string|min:8',
            'role'          => 'required|exists:roles,name',
            'department_id' => 'nullable|exists:departments,id',
            'phone'         => 'nullable|string|max:20',
        ];
    }
}
