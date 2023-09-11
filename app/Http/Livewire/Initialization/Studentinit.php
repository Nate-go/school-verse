<?php

namespace App\Http\Livewire\Initialization;

use App\Constant\UserRole;
use App\Models\Grade;
use App\Models\Room;
use App\Models\Student;
use App\Models\User;
use App\Services\UtilService;
use DB;
use Livewire\Component;

class Studentinit extends Component
{
    public $students;

    public $selectedtudent;

    public $studentName;

    public $grades;

    public $selectedGrades;

    public $selectedGradeNames;

    public $rooms;

    public $selectedRooms;

    public $selectedRoomNames;

    protected $utilService;

    public function boot(UtilService $utilService)
    {
        $this->utilService = $utilService;
    }

    public function mount()
    {
        $this->formGenerate();
    }

    public function formGenerate()
    {
        $this->setStudent();
        $this->setGrades();
        $this->selectedStudent = null;
        $this->selectedGrades = [];
        $this->selectedRooms = [];
        $this->studentName = '';
    }

    private function setGrades()
    {
        $result = Grade::selectColumns(['id', 'name'])->get();
        $this->grades = $this->mappingData($result);
    }

    private function setRoom()
    {
        $result = Room::select(
            'rooms.id',
            DB::raw('CONCAT(grades.name, " ", rooms.name) as name'),
        )->join('grades', 'rooms.grade_id', '=', 'grades.id')->whereIn('grade_id', $this->selectedGrades)->get();
        $this->rooms = $this->mappingData($result);
    }

    private function setStudent()
    {
        $currentSchoolYearId = $this->utilService->getCurrentSchoolYear();
        $result = User::selectColumns(['users.id', 'username as name'])->leftJoin('students', function ($join) use ($currentSchoolYearId) {
            $join->on('users.id', '=', 'students.user_id')
                ->where('students.school_year_id', '=', $currentSchoolYearId);
        })
            ->whereNull('students.user_id')
            ->where('role', UserRole::STUDENT)
            ->contain('username', $this->studentName)
            ->get();
        $this->students = $this->mappingData($result);
    }

    public function updatedStudentName()
    {
        $this->setStudent();

        $selectedStudentTemp = null;
        foreach ($this->students as $student) {
            if ($this->selectedStudent == $student['id']) {
                $selectedStudentTemp = $student['id'];
                break;
            }
        }

        $this->selectedStudent = $selectedStudentTemp;
    }

    public function selectGrades($value)
    {
        $key = array_search($value, $this->selectedGrades);
        if ($key === false) {
            $this->selectedGrades = [$value];
        } else {
            unset($this->selectedGrades[$key]);
        }

        $this->setSelectedNames($this->selectedGradeNames, $this->selectedGrades, $this->grades);

        $this->setRoom();

        $this->removeItem($this->selectedRooms, $this->rooms);

        $this->setSelectedNames($this->selectedRoomNames, $this->selectedRooms, $this->rooms);
    }

    public function selectrooms($value)
    {
        $key = array_search($value, $this->selectedRooms);
        if ($key === false) {
            $this->selectedRooms = [$value];
        } else {
            unset($this->selectedRooms[$key]);
        }

        $this->setSelectedNames($this->selectedRoomNames, $this->selectedRooms, $this->rooms);
    }

    private function setSelectedNames(&$selectedNames, $selectedValues, $source)
    {
        $selectedNames = [];
        foreach ($source as $item) {
            if (in_array($item['id'], $selectedValues)) {
                $selectedNames[] = $item['name'];
            }
        }
    }

    private function removeItem(&$selectedItems, $source)
    {
        $temp = [];
        foreach ($selectedItems as $selectedItem) {
            foreach ($source as $item) {
                if ($item['id'] == $selectedItem) {
                    $temp[] = $selectedItem;
                }
            }
        }
        $selectedItems = $temp;
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
        $student = [
            'user_id' => $this->selectedStudent,
            'room_id' => $this->selectedRooms[0] ?? null,
            'grade_id' => $this->selectedGrades[0] ?? null,
            'school_year_id' => $this->utilService->getCurrentSchoolYear(),
        ];

        $result = $this->isValid($student);

        if (! $result['isValid']) {
            $this->notify('error', $result['message']);

            return;
        }

        $newStudent = Student::create($student);

        if ($newStudent) {
            $this->notify('success', 'Create students successfull');
        } else {
            $this->notify('error', 'Create students fail');
        }

    }

    private function isValid($student)
    {
        if ($student['user_id'] == null) {
            return ['isValid' => false, 'message' => 'student is invalid'];
        }

        if (empty($student['room_id'])) {
            return ['isValid' => false, 'message' => 'Select room please'];
        }

        if ($this->isExist($student['user_id'], $student['school_year_id'])) {
            return ['isValid' => false, 'message' => 'This student and room is exist'];
        }

        return ['isValid' => true];
    }

    private function isExist($userId, $schoolYearId)
    {
        $result = Student::where('user_id', $userId)
            ->where('school_year_id', $schoolYearId)
            ->exists();

        return $result;
    }

    public function addAndNext()
    {
        $this->create();
        $this->formGenerate();
    }

    public function render()
    {
        return view('livewire.initialization.studentinit');
    }
}
