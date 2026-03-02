<?php

namespace App\Domains\Department\Repositories;

use App\Domains\Department\Models\Department;

class DepartmentRepository
{
    public function __construct(protected Department $model) {}

    public function getActive()
    {
        return $this->model->where('is_active', true)->get();
    }
}
