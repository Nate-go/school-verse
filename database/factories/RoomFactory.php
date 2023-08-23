<?php

namespace Database\Factories;

use DB;
use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

class RoomFactory extends Factory
{
    public function definition(): array
    {
        return [
            'grade_id' => DB::table('grades')->inRandomOrder()->value('id'),
            'name' => Str::random(4),
            'school_year_id' => DB::table('school_years')->inRandomOrder()->value('id'),
            'homeroom_teacher_id' => DB::table('users')->where('users.role', 1)->inRandomOrder()->value('id'),
        ];
    }
}
