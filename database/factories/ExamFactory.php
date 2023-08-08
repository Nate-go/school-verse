<?php

namespace Database\Factories;

use DB;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Exam>
 */
class ExamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => random_int(0,3),
            'subject_id' => DB::table('subjects')->inRandomOrder()->value('id'),
            'student_id' => DB::table('room_students')->inRandomOrder()->value('id'),
            'score' => random_int(0, 10),
            'review' => Str::random(20),
        ];
    }
}
