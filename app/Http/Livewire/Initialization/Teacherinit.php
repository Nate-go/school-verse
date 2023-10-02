<?php

namespace App\Http\Livewire\Initialization;

use App\Constant\UserRole;
use App\Http\Livewire\BaseComponent;
use App\Models\Grade;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use DB;

class Teacherinit extends BaseComponent
{
    public $teachers;

    public $selectedTeacher;

    public $teacherName;

    public $grades;

    public $selectedGrades;

    public $selectedGradeNames;

    public $subjects;

    public $selectedSubjects;

    public $selectedSubjectNames;

    public function mount()
    {
        $this->formGenerate();
    }

    public function formGenerate()
    {
        $this->setTeacher();
        $this->setGrades();
        $this->selectedTeacher = null;
        $this->selectedGrades = [];
        $this->selectedSubjects = [];
        $this->teacherName = '';
    }

    private function setGrades()
    {
        $result = Grade::selectColumns(['id', 'name'])->get();
        $this->grades = $this->mappingData($result);
    }

    private function setSubject()
    {
        $result = Subject::select(
            'subjects.id',
            DB::raw('CONCAT(subjects.name, " ", grades.name) as name'),
        )->join('grades', 'subjects.grade_id', '=', 'grades.id')->whereIn('grade_id', $this->selectedGrades)->get();
        $this->subjects = $this->mappingData($result);
    }

    private function setTeacher()
    {
        $result = User::selectColumns(['id', 'username as name'])->where('role', UserRole::TEACHER)->contain('username', $this->teacherName)->get();
        $this->teachers = $this->mappingData($result);
    }

    public function updatedTeacherName()
    {
        $this->setTeacher();

        $selectedTeacherTemp = null;
        foreach ($this->teachers as $teacher) {
            if ($this->selectedTeacher == $teacher['id']) {
                $selectedTeacherTemp = $teacher['id'];
                break;
            }
        }

        $this->selectedTeacher = $selectedTeacherTemp;
    }

    public function selectGrades($value)
    {
        $key = array_search($value, $this->selectedGrades);
        if ($key === false) {
            $this->selectedGrades[] = $value;
        } else {
            unset($this->selectedGrades[$key]);
        }

        $this->setSelectedNames($this->selectedGradeNames, $this->selectedGrades, $this->grades);

        $this->setSubject();

        $this->removeItem($this->selectedSubjects, $this->subjects);

        $this->setSelectedNames($this->selectedSubjectNames, $this->selectedSubjects, $this->subjects);
    }

    public function selectSubjects($value)
    {
        $key = array_search($value, $this->selectedSubjects);
        if ($key === false) {
            $this->selectedSubjects[] = $value;
        } else {
            unset($this->selectedSubjects[$key]);
        }

        $this->setSelectedNames($this->selectedSubjectNames, $this->selectedSubjects, $this->subjects);
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

    public function render()
    {
        return view('livewire.initialization.teacherinit');
    }

    public function create()
    {
        $teacher = [
            'user_id' => $this->selectedTeacher,
            'subject_id' => $this->selectedSubjects,
        ];

        $result = $this->isValid($teacher);

        if (! $result['isValid']) {
            $this->notify('error', $result['message']);

            return;
        }

        foreach ($this->selectedSubjects as $subjectId) {
            Teacher::create([
                'user_id' => $this->selectedTeacher,
                'subject_id' => $subjectId,
            ]);
        }

        $this->notify('success', 'Create teachers successfull');
    }

    private function isValid($teacher)
    {
        if ($teacher['user_id'] == null) {
            return ['isValid' => false, 'message' => 'Teacher is invalid'];
        }

        if (empty($teacher['subject_id'])) {
            return ['isValid' => false, 'message' => 'Select subject please'];
        }

        if ($this->isExist($teacher['user_id'], $teacher['subject_id'])) {
            return ['isValid' => false, 'message' => 'This teacher and subject is exist'];
        }

        return ['isValid' => true];
    }

    private function isExist($userId, $subjectId)
    {
        $result = Teacher::where('user_id', $userId)
            ->whereIn('subject_id', $subjectId)
            ->count();

        return $result > 0;
    }

    public function addAndNext()
    {
        $this->create();
        $this->formGenerate();
    }
}
