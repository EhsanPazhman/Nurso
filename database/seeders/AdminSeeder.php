<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@nurso.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'parent_id' => null,
        ]);
        $admin->update(['path' => $admin->id . '/']);
    }
}
