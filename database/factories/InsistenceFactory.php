<?php

namespace Database\Factories;

use DB;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class InsistenceFactory extends Factory
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
            'room_id' => DB::table('rooms')->inRandomOrder()->value('id'),
            'status' => random_int(0,2),
            'content' => Str::random(20),
            'feedback' => Str::random(20),
        ];
    }
}
