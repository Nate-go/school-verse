<?php

namespace App\Http\Livewire\Initialization;

use App\Constant\UserRole;
use App\Models\Grade;
use App\Models\Room;
use App\Models\User;
use App\Services\ConstantService;
use App\Services\UtilService;
use Livewire\Component;
use Livewire\WithFileUploads;

class Roominit extends Component
{
    use WithFileUploads;

    public $name;

    public $image;

    public $selectedGrade;

    public $grades;

    public $selectedTeacher;

    public $teachers;

    public $teacherName;

    protected $constantService;

    protected $utilService;

    public function mount()
    {
        $this->formGenerate();
        $this->getGrades();
    }

    public function formGenerate()
    {
        $this->name = '';
        $this->image = null;
        $this->selectedGrade = null;
        $this->selectedTeacher = null;
        $this->teacherName = '';
        $this->getTeachers();
    }

    public function boot(ConstantService $constantService, UtilService $utilService)
    {
        $this->constantService = $constantService;
        $this->utilService = $utilService;
    }

    public function render()
    {
        return view('livewire.initialization.roominit');
    }

    public function updatedTeacherName($value)
    {
        $this->getTeachers();

        $selectedTeacherTemp = null;
        foreach ($this->teachers as $teacher) {
            if ($this->selectedTeacher == $teacher['id']) {
                $selectedTeacherTemp = $teacher['id'];
                break;
            }
        }

        $this->selectedTeacher = $selectedTeacherTemp;
    }

    private function getGrades()
    {
        $result = Grade::selectColumns(['id', 'name'])->get();
        $this->grades = $this->mappingData($result);
    }

    private function getTeachers()
    {
        $result = User::selectColumns(['id', 'username as name'])->where('role', UserRole::TEACHER)->contain('username', $this->teacherName)->get();
        $this->teachers = $this->mappingData($result);
    }

    private function mappingData($data)
    {
        $result = [];
        foreach ($data as $item) {
            $result[] = ['name' => $item->name, 'id' => $item->id];
        }

        return $result;
    }

    public function create()
    {

        $room = [
            'grade_id' => $this->selectedGrade,
            'name' => trim($this->name),
            'school_year_id' => $this->utilService->getCurrentSchoolYear(),
            'homeroom_teacher_id' => $this->selectedTeacher,
        ];

        $result = $this->isValidData($room);

        if (! $result['isValid']) {
            $this->notify('error', $result['message']);

            return;
        }

        $room['image_url'] = $this->saveImage();

        $newRoom = Room::create($room);

        if ($newRoom) {
            $this->notify('success', 'Create room successful');
        } else {
            $this->notify('error', 'Create room fail');
        }
    }

    private function isValidData($room)
    {
        if ($room['name'] === '') {
            return ['isValid' => false, 'message' => 'Name is invalid'];
        }

        if (! $room['grade_id']) {
            return ['isValid' => false, 'message' => 'Grade have not been selected'];
        }

        if (! $room['homeroom_teacher_id']) {
            return ['isValid' => false, 'message' => 'Homeroom teacher have not been selected'];
        }

        $roomExists = Room::where('grade_id', $room['grade_id'])
            ->where('name', $room['name'])
            ->where('school_year_id', $room['school_year_id'])
            ->exists();

        if ($roomExists) {
            return ['isValid' => false, 'message' => 'This room has been exist'];
        }

        return ['isValid' => true];
    }

    public function saveImage()
    {
        if ($this->image) {
            $imageName = time().'.'.$this->image->extension();
            $this->image->storeAs('public/images', $imageName);
            $url = asset('storage/images/'.$imageName);

            return $url;
        } else {
            return asset('storage/images/default-image.png');
        }
    }

    public function addAndNext()
    {
        $this->create();
        $this->formGenerate();
    }
}
