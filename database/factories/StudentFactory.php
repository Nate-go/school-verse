<?php

namespace Database\Factories;

use DB;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    public function definition(): array
    {
        do {
            $user_id = DB::table('users')->where('users.role', 2)->inRandomOrder()->value('id');
            $school_year_id = DB::table('school_years')->inRandomOrder()->value('id');
        } while ($this->studentExist($user_id, $school_year_id));

        $grade_id = DB::table('grades')->inRandomOrder()->value('id');

        return [
            'user_id' => $user_id,
            'school_year_id' => $school_year_id,
            'grade_id' => $grade_id,
            'room_id' => DB::table('rooms')->where('rooms.grade_id', $grade_id)->inRandomOrder()->value('id'),
        ];
    }

    public function studentExist($user_id, $school_year_id)
    {
        $exists = DB::table('students')
            ->where('user_id', $user_id)
            ->where('school_year_id', $school_year_id)
            ->exists();

        return $exists;
    }
}
