<?php

namespace Database\Factories;

use App\Models\User;
use DB;
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
            'user_id' => DB::table('users')->inRandomOrder()->value('id'),
            'username' => fake()->userName(),
            'gender' => random_int(0,2),
            'address' => fake()->address(),
            'phonenumber' => fake()->phoneNumber(),
            'realname' => fake()->name(),
            'date_of_birth' => fake()->dateTimeBetween("-18 years", "-15 years"),
        ];
    }
}
