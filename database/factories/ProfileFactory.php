<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    public function definition(): array
    {
        return [
            'gender' => random_int(0, 2),
            'address' => fake()->address(),
            'phonenumber' => fake()->phoneNumber(),
            'date_of_birth' => null,
        ];
    }
}
