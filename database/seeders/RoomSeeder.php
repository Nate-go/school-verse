<?php

namespace Database\Seeders;

use App\Models\Grade;
use App\Models\Room;
use App\Models\SchoolYear;
use App\Models\User;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $grades = Grade::selectColumns(['id'])->get();
        $schoolYears = SchoolYear::selectColumns(['id'])->get();
        foreach ($schoolYears as $schoolYear) {
            foreach ($grades as $grade) {
                $numberRoom = random_int(2, 3);
                foreach (range(0, $numberRoom - 1) as $number) {
                    Room::create([
                        'grade_id' => $grade->id,
                        'name' => 'C'.str($number + 1),
                        'school_year_id' => $schoolYear->id,
                        'homeroom_teacher_id' => User::where('role', 1)->inRandomOrder()->value('id'),
                    ]);
                }
            }
        }
    }
}
