<?php

namespace App\Http\Livewire\Detail;

use App\Models\SchoolYear;
use App\Models\Student;
use App\Models\User;
use App\Services\UtilService;
use DB;
use App\Http\Livewire\BaseComponent;

class Studentdetail extends BaseComponent
{
    public $itemId;

    public $displayRooms;

    public $imageUrl;

    public $username;

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
        $this->setStudent();
        $this->setInit();
        $this->setDisplayRooms();
    }

    private function setStudent()
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

    public function setDisplayRooms()
    {
        $this->displayRooms = [];

        $data = Student::select(
            'rooms.id',
            'rooms.image_url as room_image',
            'users.username as teacher_name',
            'users.image_url as teacher_image',
            DB::raw('CONCAT(grades.name, " ", rooms.name) as room_name')
        )
            ->join('rooms', 'rooms.id', '=', 'students.room_id')
            ->join('users', 'users.id', '=', 'rooms.homeroom_teacher_id')
            ->join('grades', 'grades.id', '=', 'students.grade_id')
            ->where('students.user_id', $this->itemId)
            ->whereOrAll(
                ['rooms.school_year_id'],
                [$this->selectedSchoolYear]
            )
            ->get();

        foreach ($data as $item) {
            $this->displayRooms[] = [
                'roomName' => $item->room_name,
                'teacherName' => $item->teacher_name,
                'roomImage' => $item->room_image,
                'teacherImage' => $item->teacher_image,
                'id' => $item->id,
            ];
        }
    }

    public function updatedSelectedSchoolYear($value)
    {
        $this->setDisplayRooms();
    }

    public function render()
    {
        return view('livewire.detail.studentdetail');
    }
}
