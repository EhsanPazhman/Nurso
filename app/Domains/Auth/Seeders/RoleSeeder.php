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
                    'patient.view.any',
                    'patient.create',
                    'patient.update.any',
                    'patient.delete',
                    'patient.restore',

                    'medical.vitals.any',

                    'staff.view',
                    'staff.create',
                    'staff.update.any',
                    'staff.delete.any',

                    'admission.manage',
                    'department.manage',
                    'bed.manage',
                    'billing.manage',
                ],
            ],

            'doctor' => [
                'label' => 'Attending Physician',
                'permissions' => [
                    'patient.view.own',
                    'patient.update.own',
                    'medical.vitals.own',
                ],
            ],

            'nurse' => [
                'label' => 'Registered Nurse',
                'permissions' => [
                    'patient.view.department',
                    'medical.vitals.department',
                ],
            ],

            'reception' => [
                'label' => 'Medical Receptionist',
                'permissions' => [
                    'patient.view.any',
                    'patient.create',
                    'admission.manage',
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
