<?php

namespace Database\Factories;

use DB;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeacherFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => DB::table('users')->where('users.role', 1)->inRandomOrder()->value('id'),
            'subject_id' => DB::table('subjects')->inRandomOrder()->value('id'),
        ];
    }
}
