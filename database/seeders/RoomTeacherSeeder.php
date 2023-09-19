<?php

namespace Database\Seeders;

use App\Models\Grade;
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
        $grades = Grade::selectColumns(['id'])->get();

        $subjects = [];
        foreach($grades as $grade) {
            $subjects[$grade->id] = Subject::selectColumns(['id'])->where('grade_id', $grade->id);
        }

        $rooms = Room::selectColumns(['id', 'grade_id'])->get();

        foreach($rooms as $room) {
            $roomsSubjects = $subjects[$room->grade_id];
            foreach($roomsSubjects as $roomSubject) {
                $teachers = Teacher::selectColumns(['id'])->where('subject_id', $roomSubject->subject_id);
                $teacherIndex = random_int(0, count($teachers) - 1);

                RoomTeacher::create([
                    'teacher_id' => $teachers[$teacherIndex]->id,
                    'room_id' => $room->id,
                ]);
            }
        }
    }
}
