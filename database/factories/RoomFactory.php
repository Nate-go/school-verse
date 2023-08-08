<?php

namespace Database\Factories;

use App\Models\Grade;
use App\Models\Semester;
use DB;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'grade_id' => DB::table('grades')->inRandomOrder()->value('id'),
            'name' => Str::random(5),
            'semester_id' => DB::table('semesters')->inRandomOrder()->value('id'),
            'homeroom_teacher_id' => DB::table('subject_teachers')->inRandomOrder()->value('id'),
        ];
    }
}
