<?php

namespace App\Services\ModelServices;

use App\Constant\UserRole;
use App\Models\Exam;
use App\Models\ExamStudent;
use Auth;
use Illuminate\Support\Carbon;

class ExamService extends BaseService
{
    public function getModel()
    {
        return Exam::class;
    }

    public function getRescorePage($examStudentId) {
        if(!$this->isRescoreable($examStudentId) or !(Auth::user()->role == UserRole::ADMIN or $this->isValidTeacher($examStudentId))) {
            return redirect()->route('notFound');
        }

        return view('teacher/exam/rescore', ['examStudentId' => $examStudentId]);
    }

    private function isRescoreable($examStudentId) {
        $now = Carbon::now();
        $result = ExamStudent::where('id', $examStudentId)
                            ->where('rescored_at', '<>', null)
                            ->where('rescored_at', '>', $now)
                            ->exists();
        return $result;
    }

    private function isValidTeacher($examStudentId) {
        $result = ExamStudent::join('exams', 'exams.id', '=', 'exam_students.exam_id')
                ->join('room_teachers', 'room_teachers.id', '=', 'exams.room_teacher_id')
                ->join('teachers', 'teachers.id', '=', 'room_teachers.teacher_id')
                ->join('users', 'users.id', '=', 'teachers.user_id')
                ->where('exam_students.id', $examStudentId)
                ->where('users.id', Auth::user()->id)
                ->exists();

        return $result;
    }
}
