<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Domains\Auth\Models\User;
use App\Domains\Auth\Seeders\RoleSeeder;
use App\Domains\Auth\Seeders\PermissionSeeder;
use App\Domains\Department\Seeders\DepartmentSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            DepartmentSeeder::class,
        ]);
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
