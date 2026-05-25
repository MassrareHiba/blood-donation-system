<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Donor;
use App\Models\Appointment;
use App\Models\BloodStock;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        $this->call(AdminSeeder::class);
        
        // Create 50 donors with their users
        $users = User::factory(50)->create(['role' => 'donor']);
        
        $users->each(function ($user) {
            $donor = Donor::factory()->create(['user_id' => $user->id]);
            Appointment::factory(3)->create(['donor_id' => $donor->id]);
        });
        
        // Blood stock
        $bloodTypes = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
        foreach ($bloodTypes as $type) {
            BloodStock::factory()->create(['blood_type' => $type]);
        }
    }
}