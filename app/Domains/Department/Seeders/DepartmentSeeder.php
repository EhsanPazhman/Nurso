<?php

namespace App\Domains\Department\Seeders;

use Illuminate\Database\Seeder;
use App\Domains\Department\Models\Department;
use Illuminate\Support\Str;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Standard hospital departments
        $departments = [
            'Emergency Room (ER)',
            'Cardiology',
            'Neurology',
            'Pediatrics',
            'General Surgery',
            'Orthopedics',
            'Internal Medicine',
            'Obstetrics and Gynecology',
            'ICU',
            'Pharmacy',
            'Laboratory',
            'Reception'
        ];

        foreach ($departments as $name) {
            Department::updateOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'name' => $name,
                    'is_active' => true,
                ]
            );
        }
    }
}
