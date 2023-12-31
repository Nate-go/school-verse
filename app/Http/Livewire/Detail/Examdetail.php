<?php

namespace App\Http\Livewire\Detail;

use App\Constant\ExamType;
use App\Constant\InsistenceTypes;
use App\Constant\NotificationStatus;
use App\Constant\OtherConstant;
use App\Constant\UserRole;
use App\Http\Livewire\BaseModalComponent;
use App\Models\ExamStudent;
use App\Models\Insistence;
use App\Models\User;
use App\Services\ConstantService;
use Auth;
use DB;

class Examdetail extends BaseModalComponent
{
    const STUDNET = UserRole::STUDENT;

    public $data;

    public $score;

    public $review;

    public $examStudentId;

    public $isPermissionDelete;

    public $isPermissionUpdate;

    protected $constantService;

    public $enable;

    public $isRescoreable;

    public function boot(ConstantService $constantService)
    {
        $this->constantService = $constantService;
    }

    public function mount($examStudentId, $roomTeacherId = null)
    {
        $this->examStudentId = $examStudentId;
        $this->formGenerate();
        if (auth()->user()->role == UserRole::STUDENT or ! $roomTeacherId) {
            $this->isPermissionDelete = false;
            $this->isPermissionUpdate = false;
        } else {
            $this->isPermissionUpdate = $roomTeacherId == $this->data['roomTeacherId'];
            $this->isPermissionDelete = true;
        }
    }

    public function isEnable()
    {
        $startTime = ExamStudent::selectColumns(['exams.created_at'])
            ->join('exams', 'exams.id', '=', 'exam_students.exam_id')
            ->where('exam_students.id', $this->examStudentId)
            ->first();

        $createdTimestamp = strtotime($startTime->created_at);
        $currentTimestamp = time();

        return $currentTimestamp - $createdTimestamp <= OtherConstant::LIMIT_TIME_SECOND;
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
        $this->enable = $this->isEnable();
        $this->isRescoreable = $this->isRescoreable();
    }

    public function isRescoreable()
    {
        if (Auth::user()->role != UserRole::STUDENT or $this->data['rescored_at'] != null) {
            return false;
        }

        return true;
    }

    public function rescore()
    {
        try {
            $newInsistence = Insistence::create([
                'user_id' => Auth::user()->id,
                'content' => 'I request for rescore about '.$this->data['subjectName'].' exam of teacher '.$this->data['teacherName'],
                'status' => \App\Constant\Insistence::PENDING,
                'type' => InsistenceTypes::RESCORE,
                'object' => json_encode(['examStudentId' => $this->examStudentId]),
            ]);

            $admin = User::where('role', UserRole::ADMIN)->first();
            $newNotify = [
                'content' => 'You have new rescore insistence',
                'from_user_id' => Auth::user()->id,
                'user_id' => $admin->id,
                'status' => NotificationStatus::UNSEEN,
                'link' => '/insistences/'.str($newInsistence->id),
            ];

            $this->realTimeNotify($newNotify);

            $this->notify('success', 'rescore request exam successfully');
        } catch (e) {
            $this->notify('error', 'rescore request exam fail');

        }
        $this->closeModal();

    }

    public function updatedScore($value)
    {
        if ($value == '') {
            $this->score = 0;
        }
    }

    public function save()
    {
        if (! $this->enable) {
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
            $this->closeModalWithEvents([
                Teacherroomdetail::getName() => 'updateScore',
            ]);

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

    public function delete()
    {
        if (! $this->enable) {
            $this->notify('error', 'Overtime to change anything');

            return;
        }
        $success = ExamStudent::where('id', $this->examStudentId)
            ->delete();

        if ($success) {
            $this->notify('success', 'Delete exam successfully');
            $this->closeModalWithEvents([
                Teacherroomdetail::getName() => 'updateScore',
            ]);

            return;
        }
        $this->notify('error', 'Delete exam fail');
    }

    public function render()
    {
        return view('livewire.detail.examdetail');
    }
}
