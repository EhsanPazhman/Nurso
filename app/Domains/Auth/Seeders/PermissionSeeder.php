<?php

namespace App\Domains\Auth\Seeders;

use Illuminate\Database\Seeder;
use App\Domains\Auth\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [

            /*
            |--------------------------------------------------------------------------
            | Patient Domain
            |--------------------------------------------------------------------------
            */

            ['name' => 'patient.view.any', 'label' => 'View all patients'],
            ['name' => 'patient.view.own', 'label' => 'View own patients'],
            ['name' => 'patient.view.department', 'label' => 'View patients in department'],
            ['name' => 'patient.create', 'label' => 'Register new patient'],
            ['name' => 'patient.update.any', 'label' => 'Update any patient'],
            ['name' => 'patient.update.own', 'label' => 'Update own patients'],
            ['name' => 'patient.delete', 'label' => 'Delete patient'],
            ['name' => 'patient.restore', 'label' => 'Restore patient'],

            /*
            |--------------------------------------------------------------------------
            | Medical Domain
            |--------------------------------------------------------------------------
            */

            ['name' => 'medical.vitals.any', 'label' => 'Record vitals for any patient'],
            ['name' => 'medical.vitals.own', 'label' => 'Record vitals for own patients'],
            ['name' => 'medical.vitals.department', 'label' => 'Record vitals in department'],

            /*
            |--------------------------------------------------------------------------
            | Staff Domain
            |--------------------------------------------------------------------------
            */

            ['name' => 'staff.view', 'label' => 'View staff list'],
            ['name' => 'staff.create', 'label' => 'Create staff'],
            ['name' => 'staff.update.any', 'label' => 'Update any staff'],
            ['name' => 'staff.update.own', 'label' => 'Update own profile'],
            ['name' => 'staff.delete.any', 'label' => 'Delete any staff'],
            ['name' => 'staff.delete.own', 'label' => 'Delete own account'],
            ['name' => 'staff.restore', 'label' => 'Restore deleted staff'],

            /*
            |--------------------------------------------------------------------------
            | Admission Domain (Future)
            |--------------------------------------------------------------------------
            */

            ['name' => 'admission.manage', 'label' => 'Manage admissions'],

            /*
            |--------------------------------------------------------------------------
            | Department & Facility Domain
            |--------------------------------------------------------------------------
            */

            ['name' => 'department.manage', 'label' => 'Manage departments'],
            ['name' => 'bed.manage', 'label' => 'Manage beds'],

            /*
            |--------------------------------------------------------------------------
            | Billing Domain (Future)
            |--------------------------------------------------------------------------
            */

            ['name' => 'billing.manage', 'label' => 'Manage billing'],

            /*
            |--------------------------------------------------------------------------
            | System
            |--------------------------------------------------------------------------
            */

            ['name' => 'system.super', 'label' => 'Super administrator access'],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['name' => $permission['name']],
                ['label' => $permission['label']]
            );
        }
    }
}
