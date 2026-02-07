<?php

namespace App\Domains\Patient\Policies;

use App\Domains\Auth\Models\User;

class PatientPolicy
{
    public function view(User $user)
    {
        return $user->can('patient.view');
    }

    public function create(User $user)
    {
        return $user->can('patient.create');
    }

    public function update(User $user)
    {
        return $user->can('patient.update');
    }

    public function delete(User $user)
    {
        return $user->can('patient.delete');
    }
    public function __construct()
    {
        //
    }
}
