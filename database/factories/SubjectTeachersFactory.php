<?php

namespace Database\Factories;

use App\Models\Subject;
use App\Models\User;
use DB;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class SubjectTeachersFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => DB::table('users')->where('role', 1)->inRandomOrder()->value('id'),
            'subject_id' => DB::table('subjects')->inRandomOrder()->value('id'),
        ];
    }
}
