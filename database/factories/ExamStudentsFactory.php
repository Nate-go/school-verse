<?php

namespace Database\Factories;

use DB;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ExamStudents>
 */
class ExamStudentsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $exam_id = DB::table('exams')->inRandomOrder()->value('id');
        return [
            'exam_id' => $exam_id,
            'student_id' => DB::table('room_students')
                            ->join('room_teachers', 'room_students.room_id', '=', 'room_teachers.room_id')
                            ->join('exam', 'room_teachers.id', '=', 'exam.teacher_id')
                            ->where('exam.id', '=', $exam_id)->inRandomOrder()->value('room_students.id'),
            'score' => random_int(0, 10),
            'review' => Str::random(20),
        ];
    }
}
