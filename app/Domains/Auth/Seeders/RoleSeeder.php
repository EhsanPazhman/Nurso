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
                'label' => 'System Owner',
                'permissions' => Permission::pluck('name')->toArray(),
            ],

            'hospital_admin' => [
                'label' => 'Hospital Administrator',
                'permissions' => [
                    'patient.view',
                    'patient.create',
                    'patient.update',
                    'patient.delete',
                    'user.view',
                    'user.create',
                    'user.update',
                    'user.delete',
                    'facility.manage'
                ],
            ],

            'reception' => [
                'label' => 'Medical Receptionist',
                'permissions' => [
                    'patient.view',
                    'patient.create',
                    'patient.update'
                ],
            ],

            'doctor' => [
                'label' => 'Attending Physician',
                'permissions' => [
                    'patient.view',
                    'patient.update'
                ],
            ],

            'nurse' => [
                'label' => 'Registered Nurse',
                'permissions' => [
                    'patient.view',
                    'medical.vitals'
                ],
            ],
        ];

        foreach ($roles as $name => $data) {
            $role = Role::updateOrCreate(
                ['name' => $name],
                ['label' => $data['label']]
            );

            $permissionIds = Permission::whereIn('name', $data['permissions'])
                ->pluck('id')
                ->toArray();

            $role->permissions()->sync($permissionIds);
        }
    }
}
