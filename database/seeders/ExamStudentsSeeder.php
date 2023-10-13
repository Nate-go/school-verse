<?php

namespace Database\Seeders;

use App\Models\Exam;
use App\Models\ExamStudent;
use App\Models\Student;
use Illuminate\Database\Seeder;

class ExamStudentsSeeder extends Seeder
{
    public $feedbackArray = [
        'Well done! You showed excellent understanding of the material.',
        'Impressive work on your exam! Keep up the good work.',
        "You're making great progress. Keep focusing on [specific area].",
        'Good job! Your effort and understanding are evident in your exam.',
        "You're on the right track. Keep practicing [specific skill].",
        "You're showing real promise. Keep up the good work!",
        'Your performance on this exam is commendable. Well done.',
        "I'm pleased with your work. Keep challenging yourself.",
        'Keep up the good work! Your efforts are paying off.',
        'Your dedication to [subject] is evident in your exam.',
        "You're doing great! Keep up the excellent work.",
        "I'm impressed. You're showing strong potential.",
        "You're on the right track. Keep up the good work.",
        'Your performance is notable. Keep pushing yourself.',
        'Good job! Your hard work is paying off in your exams.',
    ];

    public $mins = [5, 50, 65, 80, 50, 65, 80];

    public $maxs = [100, 70, 79, 100, 70, 79, 100];

    public function run(): void
    {
        $exams = Exam::selectColumns(['exams.id', 'room_id'])
            ->join('room_teachers', 'room_teachers.id', '=', 'exams.room_teacher_id')->get();

        foreach ($exams as $exam) {
            $students = Student::selectColumns(['id'])
                ->where('room_id', $exam->room_id)
                ->get();

            foreach ($students as $student) {
                $reviewIndex = random_int(0, count($this->feedbackArray) - 1);
                $typeStudent = $student->id%5;
                ExamStudent::create([
                    'exam_id' => $exam->id,
                    'student_id' => $student->id,
                    'score' => random_int($this->mins[$typeStudent], $this->maxs[$typeStudent]),
                    'review' => $this->feedbackArray[$reviewIndex],
                ]);
            }
        }
    }
}
