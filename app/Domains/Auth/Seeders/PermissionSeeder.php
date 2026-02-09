<?php

namespace App\Domains\Auth\Seeders;

use Illuminate\Database\Seeder;
use App\Domains\Auth\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // Patient Domain
            ['name' => 'patient.view',   'label' => 'View patients'],
            ['name' => 'patient.create', 'label' => 'Create patient'],
            ['name' => 'patient.create', 'label' => 'Create patient'],
            ['name' => 'patient.update', 'label' => 'Update patient'],
            ['name' => 'patient.delete', 'label' => 'Delete patient'],

            // admission.create
            // medical_record.view
            // billing.manage
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission['name']],
                ['label' => $permission['label']]
            );
        }
    }
}
