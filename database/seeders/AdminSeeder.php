<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Create the default admin user.
     * Run: php artisan db:seed --class=AdminSeeder
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@hoodiel.com'],
            [
                'name'     => 'Admin',
                'email'    => 'admin@hoodiel.com',
                'password' => Hash::make('admin123'),
                'role'     => 'admin',
            ]
        );

        $this->command->info('Admin user ready: admin@hoodiel.com / admin123');
    }
}
