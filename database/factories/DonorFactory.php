<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Donor;
use Illuminate\Database\Eloquent\Factories\Factory;

class DonorFactory extends Factory
{
    protected $model = Donor::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'phone' => $this->faker->phoneNumber(),
            'blood_type' => $this->faker->randomElement(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']),
            'address' => $this->faker->address(),
            'city' => $this->faker->city(),
            'date_of_birth' => $this->faker->dateTimeBetween('-60 years', '-18 years'),
            'gender' => $this->faker->randomElement(['male', 'female', 'other']),
            'weight' => $this->faker->numberBetween(50, 120),
            'medical_history' => $this->faker->optional()->sentence(),
            'last_donation_date' => $this->faker->optional()->dateTimeBetween('-2 years', 'now'),
            'is_available' => $this->faker->boolean(80),
        ];
    }
}