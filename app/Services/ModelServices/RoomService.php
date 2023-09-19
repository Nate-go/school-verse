<?php

namespace App\Services\ModelServices;

use App\Constant\TableData;
use App\Constant\UserRole;
use App\Models\Room;
use App\Models\RoomTeacher;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Facades\Auth;

class RoomService extends BaseService
{
    protected $schoolYearService;

    public function __construct(SchoolYearService $schoolYearService)
    {
        parent::__construct();
        $this->schoolYearService = $schoolYearService;
    }

    public function getModel()
    {
        return Room::class;
    }

    public function getUrlForStudent()
    {
        $currentSchoolYearId = $this->schoolYearService->getCurrentSchoolYear();

        $room = $this->model->selectColumns(['room_id'])->where('user_id', Auth::user()->id)->where('school_year_id', $currentSchoolYearId)->first();

        return '/rooms/'.str($room->id);
    }

    public function getPageForAdmin()
    {
        $data = TableData::ROOMS;
        $this->tableService->setTableForm($data);

        return view('admin/room/rooms', ['tableSource' => $data]);
    }

    public function getPageForTeacher()
    {
        $data = TableData::ROOMS;
        $this->tableService->setTableForm($data);

        return view('admin/room/rooms', ['tableSource' => $data]);
    }

    public function getPageForStudent()
    {
        $data = TableData::ROOMS;
        $this->tableService->setTableForm($data);

        return view('admin/room/rooms', ['tableSource' => $data]);
    }

    public function getInitizationForm()
    {
        return view('admin/room/rooms-initialization');
    }

    public function getDetailPageForAdmin($id)
    {
        return view('admin/room/rooms-detail', ['id' => $id]);
    }

    public function getHomeroomPage($roomId) {
        if(Auth::user()->role == UserRole::ADMIN or $this->isHomeroomTeacher($roomId)) {
            return view('teacher/room/homerooms-detail', ['id' => $roomId]);
        }
        return redirect()->route('notPermission');
    }

    private function isHomeroomTeacher($roomId) {
        $result = $this->model->where('homeroom_teacher_id', Auth::user()->id)
                        ->where('id', $roomId)->exists();
        
        return $result;
    }

    public function getStudentRoom($userId, $roomId) {
        if (Auth::user()->role == UserRole::ADMIN or Auth::user()->id == $userId) {
            $studentId = $this->getStudentId($userId, $roomId);
            if($studentId) {
                return view('student/room/student-rooms-detail', ['studentId' => $studentId]);
            }
            return redirect()->route('notFound');
        }
        return redirect()->route('notPermission');
    }

    private function getStudentId($userId, $roomId) {
        $result = Student::selectColumns(['id'])
                        ->where('user_id', $userId)
                        ->where('room_id', $roomId)
                        ->first();

        return $result != null ? $result->id : null; 
    }

    public function getTeacherRoom($roomTeacherId)
    {
        if (Auth::user()->role == UserRole::ADMIN or $this->isTeacherValid($roomTeacherId)) {
            return view('teacher/room/teacher-rooms-detail', ['roomTeacherId' => $roomTeacherId]);
        }
        return redirect()->route('notPermission');
    }

    private function isTeacherValid($roomTeacherId) {
        $result = Teacher::join('room_teachers')
                        ->where('room_teachers.id', $roomTeacherId)
                        ->where('teachers.user_id', Auth::user()->id)
                        ->exists();

        return $result;
    } 
}
