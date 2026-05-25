<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BloodStock;

class BloodStockSeeder extends Seeder
{
    public function run(): void
    {
        $bloodTypes = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];

        foreach ($bloodTypes as $type) {
            BloodStock::create([
                'blood_type' => $type,
                'units_available' => rand(5, 50),
                'units_reserved' => 0,
                'storage_location' => 'Main Storage - Cold Room A',
                'notes' => 'Initial stock seed',
            ]);
        }
    }
}