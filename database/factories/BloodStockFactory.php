<?php

namespace Database\Factories;

use App\Models\BloodStock;
use Illuminate\Database\Eloquent\Factories\Factory;

class BloodStockFactory extends Factory
{
    protected $model = BloodStock::class;

    public function definition(): array
    {
        return [
            'blood_type' => $this->faker->randomElement(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']),
            'units_available' => $this->faker->numberBetween(0, 100),
            'units_reserved' => $this->faker->numberBetween(0, 20),
            'storage_location' => 'Cold Room ' . $this->faker->randomLetter(),
            'expiry_date' => $this->faker->dateTimeBetween('+1 month', '+6 months'),
            'notes' => $this->faker->optional()->sentence(),
        ];
    }
}