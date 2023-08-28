<?php

namespace Database\Factories;

use App\Services\UtilService;
use App\Traits\ServiceInjection\InjectionService;
use DB;
use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

class ExamStudentFactory extends Factory
{
    use InjectionService;
    protected $utilService;

    public function definition(): array
    {
        $this->setInjection([UtilService::class]);

        do {
            $exam_id = DB::table('exams')->inRandomOrder()->value('id');
            $room_teacher_id = DB::table('exams')->where('exams.id', $exam_id)->value('room_teacher_id');
            $room_id = DB::table('room_teachers')->where('room_teachers.id', $room_teacher_id)->inRandomOrder()->value('room_id');
            $student_ids = DB::table('students')->where('students.room_id', $room_id)->inRandomOrder()->value('id');
        } while ($student_ids === null);

        return [
            'exam_id' => $exam_id,
            'student_id' => $this->utilService->randValues([$student_ids]),
            'score' => random_int(0, 100) / 10,
            'review' => Str::random(10),
        ];
    }
}
