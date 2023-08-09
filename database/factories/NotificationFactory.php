<?php

namespace Database\Factories;

use App\Models\User;
use DB;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notification>
 */
class NotificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'content' => Str::random(20),
            'user_id' => DB::table('users')->inRandomOrder()->value('id'),
            'status' => random_int(0,1),
            'uri' => Str::random(20),
        ];
    }
}