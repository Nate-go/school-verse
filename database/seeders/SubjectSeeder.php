<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subjects = [
            ['name' => 'Mathematics', 'number_of_lesson' => 105, 'coefficient' => 2],
            ['name' => 'Physics', 'number_of_lesson' => 70, 'coefficient' => 1],
            ['name' => 'Chemistry', 'number_of_lesson' => 70, 'coefficient' => 1],
            ['name' => 'Literature', 'number_of_lesson' => 105, 'coefficient' => 2],
            ['name' => 'History', 'number_of_lesson' => 70, 'coefficient' => 1],
            ['name' => 'Geography', 'number_of_lesson' => 70, 'coefficient' => 1],
            ['name' => 'Civic Education', 'number_of_lesson' => 70, 'coefficient' => 1],
            ['name' => 'Physical Education', 'number_of_lesson' => 70, 'coefficient' => 1],
            ['name' => 'Computer Science', 'number_of_lesson' => 70, 'coefficient' => 1],
            ['name' => 'English', 'number_of_lesson' => 70, 'coefficient' => 1],
            ['name' => 'Technology', 'number_of_lesson' => 70, 'coefficient' => 1],
            ['name' => 'Biology', 'number_of_lesson' => 70, 'coefficient' => 1],
            ['name' => 'National Defense Education', 'number_of_lesson' => 70, 'coefficient' => 1],
            ['name' => 'Career Orientation', 'number_of_lesson' => 105, 'coefficient' => 1],
        ];

        foreach ($subjects as $subject) {
            Subject::create($subject);
        }
    }
}
