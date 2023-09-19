<?php

namespace Database\Seeders;

use App\Constant\UserRole;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teachers = User::selectColumns(['id'])->where('role', UserRole::TEACHER)->get();
        $subjects = Subject::selectColumns(['id'])->get();

        foreach($subjects as $subject) {
            $numberTeachers = random_int(2, 3);
            foreach(range(0, $numberTeachers - 1) as $number) {
                $randTeacher = random_int(0, count($teachers) - 1);
                Teacher::create([
                    'user_id' => $teachers[$randTeacher]->id,
                    'subject_id' => $subject->id,
                ]);
            }
        }
    }
}
