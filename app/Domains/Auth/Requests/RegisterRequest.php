<?php

namespace App\Domains\Auth\Requests;

use App\Domains\Auth\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', User::class);
    }

    public function rules(): array
    {
        return [
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|string|min:8',
            'role'          => 'required|exists:roles,name',
            'department_id' => 'nullable|exists:departments,id',
            'phone'         => 'nullable|string|max:20',
        ];
    }
}
