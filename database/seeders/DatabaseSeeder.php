<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['username' => 'superadmin'],
            [
                'name' => 'Super Administrator',
                'email' => 'superadmin@simrs.id',
                'password' => bcrypt('admin123'),
                'role' => 'superadmin',
                'is_active' => true,
            ]
        );

        User::updateOrCreate(
            ['username' => 'pengakses'],
            [
                'name' => 'Pengakses API SIMRS',
                'email' => 'pengakses@simrs.id',
                'password' => bcrypt('user123'),
                'role' => 'pengakses',
                'is_active' => true,
            ]
        );
    }
}
