<?php

namespace App\Domains\Auth\Seeders;

use Illuminate\Database\Seeder;
use App\Domains\Auth\Models\Role;
use App\Domains\Auth\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'super_admin' => [
                'label' => 'Super Admin',
                'permissions' => Permission::pluck('id')->toArray(),
            ],

            'hospital_admin' => [
                'label' => 'Hospital Admin',
                'permissions' => [
                    'patient.view',
                    'patient.create',
                    'patient.update',
                    'patient.delete',
                ],
            ],

            'reception' => [
                'label' => 'Reception',
                'permissions' => [
                    'patient.view',
                    'patient.create',
                ],
            ],

            'doctor' => [
                'label' => 'Doctor',
                'permissions' => [
                    'patient.view',
                ],
            ],

            'nurse' => [
                'label' => 'Nurse',
                'permissions' => [
                    'patient.view',
                ],
            ],
        ];

        foreach ($roles as $name => $data) {
            $role = Role::firstOrCreate(
                ['name' => $name],
                ['label' => $data['label']]
            );

            if ($name === 'super_admin') {
                $role->permissions()->sync($data['permissions']);
            } else {
                $permissionIds = Permission::whereIn('name', $data['permissions'])
                    ->pluck('id')
                    ->toArray();

                $role->permissions()->sync($permissionIds);
            }
        }
    }
}
