<?php

namespace Database\Seeders;

use App\Constant\ExamType;
use App\Models\Exam;
use App\Models\RoomTeacher;
use DB;
use Illuminate\Database\Seeder;

class ExamSeeder extends Seeder
{
    public $types = [
        ['value' => ExamType::ORAL, 'name' => 'ORAL', 'min' => 1, 'max' => 4],
        ['value' => ExamType::FIFTEEN_MINUTES, 'name' => 'FIFTEEN_MINUTES', 'min' => 1, 'max' => 3],
        ['value' => ExamType::LESSON, 'name' => 'LESSON', 'min' => 1, 'max' => 2],
        ['value' => ExamType::MIDTERM, 'name' => 'MIDTERM', 'min' => 1, 'max' => 2],
        ['value' => ExamType::FINAL_SEMESTER, 'name' => 'FINAL_SEMESTER', 'min' => 1, 'max' => 1],
    ];

    public function run(): void
    {
        $roomTeachers = RoomTeacher::selectColumns(['id'])->get();

        foreach($roomTeachers as $roomTeacher) {
            foreach($this->types as $type) {
                $numberExam = random_int($type['min'], $type['max']);
                foreach(range(0, $numberExam - 1) as $number) {
                    Exam::create([
                        'content' => $type['name'] . ' ' . str($number + 1),
                        'room_teacher_id' => $roomTeacher->id,
                        'type' => $type['value'],
                    ]);
                }
            }
        }
    }
}
