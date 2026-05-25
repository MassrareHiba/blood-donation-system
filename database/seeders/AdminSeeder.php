<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Check if admin already exists
        if (!User::where('email', 'admin@blooddonation.com')->exists()) {
            User::create([
                'name' => 'System Administrator',
                'email' => 'admin@blooddonation.com',
                'password' => Hash::make('Admin@1234'),
                'role' => 'admin',
            ]);
        }
    }
}