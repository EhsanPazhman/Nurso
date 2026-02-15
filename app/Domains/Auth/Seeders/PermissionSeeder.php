<?php

namespace App\Domains\Auth\Seeders;

use Illuminate\Database\Seeder;
use App\Domains\Auth\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // Patient Registry
            ['name' => 'patient.view',   'label' => 'View patient records'],
            ['name' => 'patient.create', 'label' => 'Register new patients'],
            ['name' => 'patient.update', 'label' => 'Update patient profiles'],
            ['name' => 'patient.delete', 'label' => 'Archive/Delete patient records'],

            // Staff & System Management
            ['name' => 'user.view',   'label' => 'View staff list'],
            ['name' => 'user.create', 'label' => 'Register new staff'],
            ['name' => 'user.update', 'label' => 'Edit staff details'],
            ['name' => 'user.delete', 'label' => 'Terminate staff access'],

            // Clinical & Bed Management (For future use)
            ['name' => 'medical.vitals', 'label' => 'Record patient vital signs'],
            ['name' => 'facility.manage', 'label' => 'Manage departments and beds'],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['name' => $permission['name']],
                ['label' => $permission['label']]
            );
        }
    }
}
