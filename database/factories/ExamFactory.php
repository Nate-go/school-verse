<?php

namespace Database\Factories;

use DB;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExamFactory extends Factory
{
    public function definition(): array
    {
        return [
            'room_teacher_id' => DB::table('room_teachers')->inRandomOrder()->value('id'),
            'type' => random_int(0, 4),
        ];
    }
}
