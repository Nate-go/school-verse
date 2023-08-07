<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {    
        return [
            'user_id' => User::all()->unique()->random(),
            'username' => fake()->userName(),
            'address' => fake()->address(),
            'phonenumber' => fake()->phoneNumber(),
            'realname' => fake()->name(),
            'date_of_birth' => fake()->dateTimeBetween("-18 years", "-15 years"),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
