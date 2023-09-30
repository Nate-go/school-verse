<?php

namespace App\Http\Livewire\Detail;

use App\Constant\Insistence;
use App\Constant\InsistenceTypes;
use App\Constant\NotificationStatus;
use App\Constant\UserRole;
use App\Models\ExamStudent;
use App\Models\Room;
use App\Models\Student;
use App\Services\ConstantService;
use Auth;
use Carbon\Carbon;
use DB;
use App\Http\Livewire\BaseComponent;

class Insistencedetail extends BaseComponent
{
    public $itemId;

    public $imageUrl;

    public $username;

    public $role;

    public $statuses;

    public $selectedStatus;

    public $content;

    public $feedback;

    public $userId;

    public $time;

    protected $constantService;

    public $isAdmin;

    public $type;

    public $object;

    const PENDDING = Insistence::PENDING;

    public function boot(ConstantService $constantService)
    {
        $this->constantService = $constantService;
    }

    public function mount($itemId)
    {
        $this->itemId = $itemId;
        $this->formGenerate();
        $this->setStatus();
        $this->isAdmin = Auth::user()->role == UserRole::ADMIN;
    }

    private function setStatus()
    {
        $this->statuses = $this->constantService->getConstantsJson(Insistence::class);
    }

    public function formGenerate()
    {
        $data = \App\Models\Insistence::selectColumns(['username', 'image_url', 'role',
            'insistences.status', 'content', 'feedback', 'insistences.created_at', 'user_id', 'insistences.type', 'insistences.object'])
            ->join('users', 'users.id', '=', 'insistences.user_id')
            ->where('insistences.id', $this->itemId)
            ->first();

        $this->username = $data->username;
        $this->imageUrl = $data->image_url;
        $this->role = $this->constantService->getNameConstant(UserRole::class, $data->role);
        $this->selectedStatus = $data->status;
        $this->content = $data->content;
        $this->time = $data->created_at;
        $this->feedback = $data->feedback;
        $this->userId = $data->user_id;
        $this->type = $data->type;
        $this->object = $data->object;
    }

    public function save()
    {
        if ($this->isAdmin) {
            $result = \App\Models\Insistence::where('id', $this->itemId)->update([
                'status' => $this->selectedStatus,
                'feedback' => $this->feedback,
            ]);
        } else {
            if ($this->selectedStatus != Insistence::PENDING) {
                $this->notify('error', 'Your insistence is not pending anymore for change');
                $this->formGenerate();

                return;
            }
            $result = \App\Models\Insistence::where('id', $this->itemId)->update([
                'content' => $this->content,
            ]);
        }

        if ($result) {
            $this->notify('success', 'Insistence update successfull');

            if ($this->type == InsistenceTypes::RESCORE and $this->selectedStatus == Insistence::ACCEPTANCE) {

                $this->rescore();
            } elseif ($this->type == InsistenceTypes::CHANGE_CLASS and $this->selectedStatus == Insistence::ACCEPTANCE) {

                $this->changeRoom();
            } else {
                $newNotify = [
                    'content' => 'Your insistence has been updated',
                    'from_user_id' => Auth::user()->id,
                    'user_id' => $this->userId,
                    'status' => NotificationStatus::UNSEEN,
                    'link' => '/insistences/'.str($this->itemId),
                ];

                $this->realTimeNotify($newNotify);
            }
        } else {
            $this->notify('error', 'Insistence update fail');
        }

        $this->formGenerate();
    }

    public function changeRoom()
    {
        $object = json_decode($this->object);

        $roomId = $object->roomId;

        $room = Room::selectColumns([
            'grade_id',
            'school_year_id',
            DB::raw('CONCAT(grades.name, "", rooms.name) as name'),
            'homeroom_teacher_id',
        ])
            ->join('grades', 'grades.id', '=', 'rooms.grade_id')
            ->where('rooms.id', $roomId)
            ->first();

        $result = Student::where('user_id', $this->userId)
            ->where('grade_id', $room->grade_id)
            ->where('school_year_id', $room->school_year_id)
            ->update([
                'room_id' => $roomId,
            ]);

        if ($result) {
            $this->notify('success', 'Change room successfully');

            $newNotify = [
                'content' => 'Your have been changed to new class: '.$room->name,
                'from_user_id' => Auth::user()->id,
                'user_id' => $this->userId,
                'status' => NotificationStatus::UNSEEN,
                'link' => '/students',
            ];

            $this->realTimeNotify($newNotify);

            $newNotify = [
                'content' => 'You have new student add to your class: '.$room->name,
                'from_user_id' => Auth::user()->id,
                'user_id' => $room->homeroom_teacher_id,
                'status' => NotificationStatus::UNSEEN,
                'link' => '/teachers/homerooms/'.$roomId,
            ];

            $this->realTimeNotify($newNotify);
        }
    }

    public function rescore()
    {
        $object = json_decode($this->object);

        $examStudentId = $object->examStudentId;

        $exam = ExamStudent::selectColumns([
            'students.user_id as student_id',
            'teachers.user_id as teacher_id',
            'subjects.name',
            'rescored_at',
        ])
            ->join('students', 'students.id', '=', 'exam_students.student_id')
            ->join('exams', 'exams.id', '=', 'exam_students.exam_id')
            ->join('room_teachers', 'room_teachers.id', '=', 'exams.room_teacher_id')
            ->join('teachers', 'teachers.id', '=', 'room_teachers.teacher_id')
            ->join('subjects', 'subjects.id', '=', 'teachers.subject_id')
            ->where('exam_students.id', $examStudentId)->first();

        if ($exam->rescored_at != null) {
            $this->notify('error', 'This exam has been rescored');

            return;
        }

        $now = Carbon::now();
        $rescoreTime = $now->addDays(7);
        ExamStudent::where('id', $examStudentId)->update(['rescored_at' => $rescoreTime]);

        $newNotify = [
            'content' => 'Your '.$exam->name.' exam rescore request has been accepted waitting for 7 days',
            'from_user_id' => Auth::user()->id,
            'user_id' => $exam->student_id,
            'status' => NotificationStatus::UNSEEN,
            'link' => '/insistences/'.str($this->itemId),
        ];

        $this->realTimeNotify($newNotify);

        $newNotify = [
            'content' => 'You have '.$exam->name.' exam rescore request, it will be block in 7 days',
            'from_user_id' => Auth::user()->id,
            'user_id' => $exam->teacher_id,
            'status' => NotificationStatus::UNSEEN,
            'link' => '/teachers/rescores/'.str($examStudentId),
        ];

        $this->realTimeNotify($newNotify);
    }

    public function delete()
    {
        if ($this->selectedStatus != Insistence::PENDING) {
            $this->notify('error', 'Your insistence is not pending anymore to delete');

            return;
        }

        $success = \App\Models\Insistence::where('id', $this->itemId)
            ->delete();

        if ($success) {
            $this->notify('success', 'Insistence delete successfull');

            return redirect('/insistences');
        } else {
            $this->notify('error', 'Insistence delete fail');
        }
    }

    public function render()
    {
        return view('livewire.detail.insistencedetail');
    }
}
