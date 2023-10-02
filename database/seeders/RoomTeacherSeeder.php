<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\RoomTeacher;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Database\Seeder;

class RoomTeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rooms = Room::selectColumns(['id', 'grade_id'])->get();

        foreach ($rooms as $room) {
            $subjects = Subject::selectColumns(['id'])->where('grade_id', $room->grade_id)->get();
            foreach ($subjects as $subject) {
                $teachers = Teacher::selectColumns(['id'])->where('subject_id', $subject->id)->get();
                $teacherIndex = random_int(0, count($teachers) - 1);

                RoomTeacher::create([
                    'teacher_id' => $teachers[$teacherIndex]->id,
                    'room_id' => $room->id,
                ]);
            }
        }
    }
}
