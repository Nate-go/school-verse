<?php

namespace Database\Factories;

use DB;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoomTeacherFactory extends Factory
{
    public function definition(): array
    {

        return [
            'teacher_id' => DB::table('teachers')->inRandomOrder()->value('id'),
            'room_id' => DB::table('rooms')->inRandomOrder()->value('id')
        ];
    }
}
