<?php

namespace Database\Seeders;

use App\Constant\ExamStatus;
use App\Constant\ExamTypeCoefficient;
use App\Models\Exam;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TotalScoreForStudent extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = Student::all();
        $subjects = Subject::all();

        foreach($students as $student) {
            $scores = [];
            foreach($subjects as $subject) {
                if($subject->grade_id == $student->grade_id) {
                    $scores[] = [
                        'value' => 0,
                        'subject_id' => $subject->id
                    ];
                }
            }
            $scores = json_encode($scores);
            $scores = json_decode($scores);
            foreach($scores as &$score) {
                $exams = Exam::selectColumns([
                    'exam_students.id',
                    'score',
                    'exams.type',
                    'subjects.name',
                ])
                    ->join('exam_students', 'exam_students.exam_id', '=', 'exams.id')
                    ->join('room_teachers', 'room_teachers.id', '=', 'exams.room_teacher_id')
                    ->join('teachers', 'teachers.id', '=', 'room_teachers.teacher_id')
                    ->join('subjects', 'subjects.id', '=', 'teachers.subject_id')
                    ->where('exam_students.student_id', $student->id)
                    ->where('teachers.subject_id', $score->subject_id)
                    //->where('exams.exam_status', ExamStatus::OFFICAL)
                    ->get();

                $totalScore = 0;
                $totalCoefficient = 0;

                foreach ($exams as $exam) {
                    $coef = ExamTypeCoefficient::COEFFICIENT[$exam['type']];
                    $totalCoefficient += $coef;
                    $totalScore += $exam['score'] * $coef;
                }

                $score->value = $totalCoefficient > 0 ? round($totalScore / $totalCoefficient, 0) : 0;
            }
            $student->scores = json_encode($scores);
            $student->save();
        }
    }
}
