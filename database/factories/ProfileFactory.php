<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
