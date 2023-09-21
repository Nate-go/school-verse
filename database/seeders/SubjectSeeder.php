<?php

namespace Database\Seeders;

use App\Models\Grade;
use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    public $subjects = [
        "Physics",
        "Chemistry",
        "History",
        "Geography",
        "Biology",
        "Civic Education",
        "Technology",
        "National Defense Education",
        "Physical Education",
        "Computer Science"
    ];

    public $mainSubjects = [
        "Mathematics",
        "Literature",
        "English",
    ];

    public function run(): void
    {
        $grades = Grade::selectColumns([
            'id'
        ])->get();

        foreach($grades as $grade) {
            foreach($this->subjects as $subjectName) {
                Subject::create([
                    'grade_id' => $grade->id,
                    'name' => $subjectName,
                    'number_lesson' => 75,
                    'coefficient' => 1,
                ]);
            }

            foreach ($this->mainSubjects as $subjectName) {
                Subject::create([
                    'grade_id' => $grade->id,
                    'name' => $subjectName,
                    'number_lesson' => 150,
                    'coefficient' => 2,
                ]);
            }
        }
    }
}
