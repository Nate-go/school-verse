<?php

namespace App\Http\Livewire\Detail;

use App\Models\Room;
use App\Models\Teacher;
use App\Services\UtilService;
use DB;
use Livewire\Component;

class Teacherdetail extends Component
{
    public $itemId;

    public $subjects;

    public $homerooms;

    protected $utilService;

    public function boot(UtilService $utilService) {
        $this->utilService = $utilService;
    }

    public function mount($itemId) {
        $this->itemId = $itemId;
        $this->setSubjects();
        $this->setHomerooms();
    }

    public function setHomerooms() {
        $data = Room::select(
            'rooms.image_url', 
            'rooms.id',
            DB::raw('CONCAT(grades.name, "", rooms.name) as room_name'),
        )
        ->join('grades', 'grades.id', '=', 'rooms.grade_id')
        ->where('school_year_id', $this->utilService->getCurrentSchoolYear())
        ->where('rooms.homeroom_teacher_id', $this->itemId)
        ->get();

        $this->homerooms = [];

        foreach ($data as $item) {
            $this->homerooms[] = [
                'imageUrl' => $item->image_url,
                'name' => $item->room_name,
                'id' => $item->id
            ];
        }
    }

    public function setSubjects() {
        $data = Teacher::select(
            'subjects.image_url', 
            'subjects.id',
            DB::raw('CONCAT(subjects.name, " ", grades.name) as subject_name'),
        )
        ->join('subjects', 'subjects.id', '=', 'teachers.subject_id')
        ->join('grades', 'grades.id', '=', 'subjects.grade_id')
        ->where('teachers.user_id', $this->itemId)
        ->get();

        $this->subjects = [];

        foreach($data as $item) {
            $this->subjects[] = [
                'imageUrl' => $item->image_url,
                'name' => $item->subject_name,
                'id' => $item->id
            ];
        }
    }

    public function render()
    {
        return view('livewire.detail.teacherdetail');
    }
}
