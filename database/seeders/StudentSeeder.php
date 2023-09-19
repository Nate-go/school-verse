<?php

namespace Database\Seeders;

use App\Constant\UserRole;
use App\Models\Room;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = User::selectColumns('id')->where('role', UserRole::STUDENT)->get();
        $rooms = Room::selectColumns(['id', 'grade_id', 'school_year_id'])->get();

        foreach($rooms as $room) {
            $numberStudent = random_int(20, 30);
            $studentIndexs = range(0, count($students) - 1);
            shuffle($studentIndexs);
            $randomStudents = array_slice($studentIndexs, 0, $numberStudent);

            foreach($randomStudents as $index) {
                Student::create([
                    'user_id' => $students[$index]->id,
                    'school_year_id' => $room->school_year_id,
                    'grade_id' => $room->grade_id,
                    'room_id' => $room->id,
                ]);
            }
        }
    }
}
