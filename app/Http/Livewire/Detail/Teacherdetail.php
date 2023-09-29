<?php

namespace App\Http\Livewire\Detail;

use App\Models\Room;
use App\Models\SchoolYear;
use App\Models\Teacher;
use App\Models\User;
use App\Services\UtilService;
use DB;
use Livewire\Component;

class Teacherdetail extends Component
{
    public $itemId;

    public $displayRooms;

    public $imageUrl;

    public $username;

    public $grades;

    public $selectedGrade;

    public $rooms;

    public $selectedRoom;

    public $subjects;

    public $selectedSubject;

    public $schoolYears;

    public $selectedSchoolYear;

    protected $utilService;

    public function boot(UtilService $utilService)
    {
        $this->utilService = $utilService;
    }

    public function mount($itemId)
    {
        $this->itemId = $itemId;
        $this->setTeacher();
        $this->setInit();
        $this->setData();
        $this->setDisplayRooms();
    }

    private function setTeacher()
    {
        $data = User::selectColumns(['image_url', 'username'])
            ->where('id', $this->itemId)
            ->first();

        $this->username = $data->username;
        $this->imageUrl = $data->image_url;
    }

    private function setInit()
    {
        $schoolYears = SchoolYear::selectColumns(['name', 'id as value'])->get();

        $this->schoolYears = $this->utilService->getJsonData($schoolYears);

        array_unshift($this->schoolYears, ['name' => 'All', 'value' => -1]);

        $this->selectedSchoolYear = $this->utilService->getCurrentSchoolYear();
    }

    private function setData()
    {
        $data = Teacher::select(
            'grades.id as grade_id',
            'grades.name as grade_name',
            'rooms.id as room_id',
            DB::raw('CONCAT(grades.name, " ", rooms.name) as room_name'),
            'subjects.id as subject_id',
            DB::raw('CONCAT(subjects.name, " ", grades.name) as subject_name'),
        )
            ->join('subjects', 'subjects.id', '=', 'teachers.subject_id')
            ->join('room_teachers', 'room_teachers.teacher_id', '=', 'teachers.id')
            ->join('rooms', 'rooms.id', '=', 'room_teachers.room_id')
            ->join('grades', 'grades.id', '=', 'subjects.grade_id')
            ->where('teachers.user_id', $this->itemId)
            ->whereOrAll(['rooms.school_year_id'], [$this->selectedSchoolYear])
            ->get();

        $this->grades = [
            ['name' => 'All', 'value' => -1],
        ];

        $this->rooms = [
            ['name' => 'All', 'value' => -1, 'grade' => -1],
        ];

        $this->subjects = [
            ['name' => 'All', 'value' => -1, 'grade' => -1],
        ];

        foreach ($data as $item) {
            if (! $this->isExist($this->grades, $item->grade_id)) {
                $this->grades[] = [
                    'name' => $item->grade_name,
                    'value' => $item->grade_id,
                ];
            }

            if (! $this->isExist($this->rooms, $item->room_id)) {
                $this->rooms[] = [
                    'name' => $item->room_name,
                    'value' => $item->room_id,
                    'grade' => $item->grade_id,
                ];
            }

            if (! $this->isExist($this->subjects, $item->subject_id)) {
                $this->subjects[] = [
                    'name' => $item->subject_name,
                    'value' => $item->subject_id,
                    'grade' => $item->grade_id,
                ];
            }
        }

        $this->selectedGrade = -1;
        $this->selectedRoom = -1;
        $this->selectedSubject = -1;
    }

    private function isExist($elements, $id)
    {
        foreach ($elements as $element) {
            if ($element['value'] == $id) {
                return true;
            }
        }

        return false;
    }

    public function setDisplayRooms()
    {
        $this->displayRooms = [];

        $this->setHomeroomClass();

        $data = Teacher::select(
            'rooms.image_url as room_image',
            'room_teachers.id',
            'subjects.image_url as subject_image',
            DB::raw('CONCAT(subjects.name, " ", grades.name) as subject_name'),
            DB::raw('CONCAT(grades.name, " ", rooms.name) as room_name')
        )
            ->join('subjects', 'subjects.id', '=', 'teachers.subject_id')
            ->join('room_teachers', 'room_teachers.teacher_id', '=', 'teachers.id')
            ->join('rooms', 'rooms.id', '=', 'room_teachers.room_id')
            ->join('grades', 'grades.id', '=', 'subjects.grade_id')
            ->where('teachers.user_id', $this->itemId)
            ->whereOrAll(
                ['rooms.id', 'subjects.id', 'rooms.school_year_id'],
                [$this->selectedRoom, $this->selectedSubject, $this->selectedSchoolYear]
            )
            ->get();

        foreach ($data as $item) {
            $this->displayRooms[] = [
                'roomName' => $item->room_name,
                'subjectName' => $item->subject_name,
                'roomImage' => $item->room_image,
                'subjectImage' => $item->subject_image,
                'id' => $item->id,
            ];
        }
    }

    private function getTeacherId($userId, $subjectId)
    {
        $result = Teacher::selectColumns(['id'])
            ->where('user_id', $userId)
            ->where('subject_id', $subjectId)
            ->first();

        return $result ? $result->id : null;
    }

    public function render()
    {
        return view('livewire.detail.teacherdetail');
    }

    public function updatedSelectedRoom($value)
    {
        $this->setDisplayRooms();
    }

    public function updatedSelectedSubject($value)
    {
        $this->setDisplayRooms();
    }

    public function updatedSelectedSchoolYear($value)
    {
        $this->setData();
        $this->setDisplayRooms();
    }

    private function setHomeroomClass()
    {
        $data = Room::select(
            'rooms.image_url as room_image',
            'rooms.id',
            DB::raw('CONCAT(grades.name, " ", rooms.name) as room_name')
        )
            ->join('grades', 'grades.id', '=', 'rooms.grade_id')
            ->where('rooms.homeroom_teacher_id', $this->itemId)
            ->whereOrAll(
                ['rooms.id', 'rooms.school_year_id'],
                [$this->selectedRoom, $this->selectedSchoolYear]
            )
            ->get();

        foreach ($data as $item) {
            $this->displayRooms[] = [
                'roomName' => $item->room_name,
                'subjectName' => 'Homeroom',
                'roomImage' => $item->room_image,
                'subjectImage' => $this->imageUrl,
                'id' => $item->id,
            ];
        }
    }
}
