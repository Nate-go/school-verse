<?php

namespace Database\Seeders;

use App\Constant\UserRole;
use App\Models\Room;
use App\Models\SchoolYear;
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
        $schoolYears = SchoolYear::selectColumns(['id'])->get();

        foreach($students as $student) {
            $randNumberYears = $this->getRandomConsecutiveNumber([[1, 0, 0], [2, 0, 0], [3, 0, 0], [0, 1, 0], [0, 2, 0], [0, 3, 0], [0, 0, 1], [0, 0, 2], [0, 0, 3], [0, 1, 2], [0, 2, 3], [0, 1, 2], [0, 2, 3], [1, 2, 3], [1, 2, 3], [1, 2, 3], [1, 2, 3]]);

            for($i=0; $i < count($randNumberYears); $i++) {
                if($randNumberYears[$i] == 0) {
                    continue;
                }
                $currentRooms = [];
                foreach($rooms as $room) {
                    if($room->school_year_id == $schoolYears[$i]->id and $room->grade_id == $randNumberYears[$i]) {
                        $currentRooms[] = $room;
                    }
                }

                $randomRoom = random_int(0, count($currentRooms) - 1);

                Student::create([
                    'user_id' => $student->id,
                    'school_year_id' => $schoolYears[$i]->id,
                    'grade_id' => $randNumberYears[$i],
                    'room_id' => $currentRooms[$randomRoom]->id,
                ]);
            }
        }
    }

    function getRandomConsecutiveNumber($sequences)
    {
        $randomIndex = array_rand($sequences);
        return $sequences[$randomIndex];
    }
}
