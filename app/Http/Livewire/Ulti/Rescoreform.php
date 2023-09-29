<?php

namespace App\Http\Livewire\Ulti;

use App\Constant\ExamType;
use App\Constant\NotificationStatus;
use App\Models\ExamStudent;
use App\Services\ConstantService;
use Auth;
use DB;
use Illuminate\Support\Carbon;
use Livewire\Component;

class Rescoreform extends Component
{
    public $data;

    public $score;

    public $review;

    public $examStudentId;

    protected $constantService;

    public function boot(ConstantService $constantService)
    {
        $this->constantService = $constantService;
    }

    public function mount($examStudentId)
    {
        $this->examStudentId = $examStudentId;
        $this->formGenerate();
    }

    public function formGenerate()
    {
        $result = ExamStudent::selectColumns([
            'student_info.username as student_name',
            'student_info.image_url as student_image',
            'teacher_info.username as teacher_name',
            'teacher_info.image_url as teacher_image',
            DB::raw('CONCAT(subjects.name, " ", grades.name) as subject_name'),
            'subjects.image_url as subject_image',
            'score',
            'review',
            'exams.type as exam_type',
            'room_teacher_id',
            'exams.content as exam_content',
            'student_info.id as user_id',
            'rescored_at',
        ])
            ->join('students', 'students.id', '=', 'exam_students.student_id')
            ->join('users as student_info', 'students.user_id', '=', 'student_info.id')
            ->join('exams', 'exams.id', '=', 'exam_students.exam_id')
            ->join('room_teachers', 'room_teachers.id', '=', 'exams.room_teacher_id')
            ->join('teachers', 'teachers.id', '=', 'room_teachers.teacher_id')
            ->join('users as teacher_info', 'teachers.user_id', '=', 'teacher_info.id')
            ->join('subjects', 'subjects.id', '=', 'teachers.subject_id')
            ->join('grades', 'grades.id', '=', 'subjects.grade_id')
            ->where('exam_students.id', $this->examStudentId)
            ->first();

        $this->data = [
            'studentName' => $result->student_name,
            'studentImage' => $result->student_image,
            'teacherName' => $result->teacher_name,
            'teacherImage' => $result->teacher_image,
            'subjectName' => $result->subject_name,
            'subjectImage' => $result->subject_image,
            'examType' => $this->constantService->getNameConstant(ExamType::class, $result->exam_type),
            'roomTeacherId' => $result->room_teacher_id,
            'examContent' => $result->exam_content,
            'userId' => $result->user_id,
            'rescored_at' => $result->rescored_at,
        ];

        $this->score = $result->score;
        $this->review = $result->review;
    }

    public function isRescoreable()
    {
        if ($this->data['rescored_at'] >= Carbon::now()) {
            return true;
        }

        return false;
    }

    public function updatedScore($value)
    {
        if ($value == '') {
            $this->score = 0;
        }
    }

    public function save()
    {
        if (! $this->isRescoreable()) {
            $this->notify('error', 'Overtime to change anything');

            return;
        }
        $success = ExamStudent::where('id', $this->examStudentId)
            ->update([
                'score' => floatval($this->score),
                'review' => $this->review,
            ]);

        if ($success) {
            $this->notify('success', 'Update exam successfully');
            $this->notifyForUpdateScore();

            return;
        }
        $this->notify('error', 'Update exam fail');
    }

    public function notifyForUpdateScore()
    {
        $newNotify = [
            'content' => 'Your '.$this->data['subjectName'].' score has been updated',
            'from_user_id' => Auth::user()->id,
            'user_id' => $this->data['userId'],
            'status' => NotificationStatus::UNSEEN,
            'link' => '/',
        ];

        $this->realTimeNotify($newNotify);
    }

    public function render()
    {
        return view('livewire.ulti.rescoreform');
    }
}
