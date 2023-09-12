<?php

namespace App\Http\Livewire\Detail;

use App\Constant\UserRole;
use App\Models\Room;
use App\Models\RoomTeacher;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use DB;
use Livewire\Component;

class Roomdetail extends Component
{
    public $schoolYear;

    public $imageUrl;

    public $gradeId;

    public $schoolYearId;

    public $name;

    public $teacherName;

    public $selectedTeacher;

    public $teachers;

    public $isTeachersOpen = true;

    public $isStudentsOpen = true;

    public $roomTeachers;

    public $subjects;

    public $subjectTeachers;

    public $selectedSubject;

    public $selectedSubjectTeacher;

    public $roomStudents;

    public $students;

    public $selectedStudent;

    public $itemId;

    public function mount($itemId) {
        $this->itemId = $itemId;
        $this->initData();
        $this->formGenerate();
    }

    public function formGenerate() {
        $this->teacherName = '';
        $homeroomTeacher = User::selectColumns('users.id')
                        ->join('rooms', 'users.id', '=', 'rooms.homeroom_teacher_id')
                        ->where('rooms.id', $this->itemId)->first();
        $this->selectedTeacher = $homeroomTeacher->id;

        $this->setTeacher();

        $this->selectedSubject = null;

        $this->selectedSubjectTeacher = null;

        $this->selectedStudent = null;

        $this->roomStudents = [];

        $this->roomTeachers = [];

        $this->setRoomTeacher();

        $this->setRoomStudent();

        $this->setSubjectTeacher();

        $this->setStudent();
    }

    private function setSubjectTeacher() {
        $subjectTeacher = Teacher::selectColumns(['teachers.id', 'username as name'])
                            ->join('users', 'users.id', '=', 'teachers.user_id')
                            ->where('teachers.subject_id', $this->selectedSubject)
                            ->get();

        $this->mappingData($this->subjectTeachers, $subjectTeacher);

        $this->slectedSubjectTeacher = null;
    }

    private function setRoomTeacher() {
        $roomTeachers = RoomTeacher::select(
            DB::raw('CONCAT(subjects.name, " ", grades.name) as subject_name'),
            'room_teachers.id',
            'users.email',
            'users.username',
            'users.image_url'
        )->join('teachers', 'teachers.id', '=', 'room_teachers.teacher_id')
            ->join('users', 'users.id', '=', 'teachers.user_id')
            ->join('subjects', 'subjects.id', '=', 'teachers.subject_id')
            ->join('grades', 'grades.id', '=', 'subjects.grade_id')
            ->where('room_teachers.room_id', $this->itemId)
            ->get();

        $this->roomTeachers = [];

        foreach($roomTeachers as $roomTeacher) {
            $this->roomTeachers[] = [
                'subject' => $roomTeacher->subject_name,
                'value' => $roomTeacher->id,
                'email' => $roomTeacher->email,
                'name'  =>$roomTeacher->username,
                'image_url' => $roomTeacher->image_url
            ];
        }
    }

    private function setRoomStudent() {
        $roomStudents = Student::select(
            'students.id',
            'users.email',
            'users.username',
            'users.image_url'
        )
            ->join('users', 'users.id', '=', 'students.user_id')
            ->where('students.room_id', '=', $this->itemId)
            ->get();

        $this->roomStudents = [];

        foreach($roomStudents as $roomStudent) {
            $this->roomStudents[] = [
                'value' => $roomStudent->id,
                'email' => $roomStudent->email,
                'name'  =>$roomStudent->username,
                'image_url' => $roomStudent->image_url
            ];
        }
    }

    private function setStudent() {
        $students = Student::selectColumns(['students.id', 'username as name'])
            ->join('users', 'users.id', '=', 'students.user_id')
            ->where('students.grade_id', $this->gradeId)
            ->where('students.room_id', '<>', $this->itemId)
            ->where('students.school_year_id', $this->schoolYearId)
            ->get();

        $this->mappingData($this->students, $students);

        $this->selectedStudent = null;
    }

    public function updatedTeacherName($value)
    {
        $this->setTeacher();

        $selectedTeacherTemp = null;
        foreach ($this->teachers as $teacher) {
            if ($this->selectedTeacher == $teacher['value']) {
                $selectedTeacherTemp = $teacher['value'];
                break;
            }
        }

        $this->selectedTeacher = $selectedTeacherTemp;
    }

    public function initData() {
        $data = Room::select(
            DB::raw('CONCAT(grades.name, "", rooms.name) as room_name'),
            'rooms.image_url as image_url',
            'school_years.name as school_year',
            'grades.id as grade_id',
            'rooms.school_year_id'
        )
            ->join('grades', 'rooms.grade_id', '=', 'grades.id')
            ->join('school_years', 'rooms.school_year_id', '=', 'school_years.id')
            ->where('rooms.id', $this->itemId)->first();

        $this->schoolYear = $data->school_year;
        $this->imageUrl = $data->image_url;
        $this->name = $data->room_name;
        $this->gradeId = $data->grade_id;
        $this->schoolYearId = $data->school_year_id;

        $subject = Subject::selectColumns(['id', 'name'])->where('grade_id', $this->gradeId)->get();

        $this->mappingData($this->subjects, $subject);
    }

    private function setTeacher() {
        $teachers = User::selectColumns(['id', 'username as name'])->where('role', UserRole::TEACHER)
                        ->contain('username', $this->teacherName)->get();

        $this->mappingData($this->teachers, $teachers);
    }

    private function mappingData(&$data, $source) {
        $data = [];
        foreach($source as $item) {
            $data[] = ['name' => $item->name, 'value' => $item->id];
        }
    }

    public function render()
    {
        return view('livewire.detail.roomdetail');
    }

    public function changeTeacherState() {
        $this->isTeachersOpen = ! $this->isTeachersOpen;
    }

    public function changeStudentState()
    {
        $this->isStudentsOpen = !$this->isStudentsOpen;
    }

    public function updatedSelectedSubject($value) {
        $this->setSubjectTeacher();
        $this->selectedSubjectTeacher = null;
    }

    public function addStudent() {
        if(!$this->selectedStudent) {
            $this->notify('error', 'You have not selected student');
            return;
        }

        $result = Student::where('id', $this->selectedStudent)->update(['room_id' => $this->itemId]);

        if($result) {
            $this->notify('success', 'Change class successfull');
        } else {
            $this->notify('error', 'Change class fail');
        }

        $this->setRoomStudent();
        $this->setStudent();
    }

    public function addSubjectTeacher() {
        if(!$this->selectedSubjectTeacher) {
            $this->notify('error', 'You have not select teacher');
            return;
        }

        if($this->isRoomTeacherExist($this->selectedSubjectTeacher)) {
            $this->notify('error', 'This teacher have already been in class');
            return;
        }

        $roomSubjectTeachersId = $this->isSubjectTeacherExist($this->selectedSubjectTeacher);

        if($roomSubjectTeachersId) {
            $result = RoomTeacher::where('id', $roomSubjectTeachersId)
                    ->update(['teacher_id' => $this->selectedSubjectTeacher]);

            if ($result) {
                $this->notify('success', 'Change teacher successfull');
            } else {
                $this->notify('error', 'Change teacher fail');
            }

        } else {
            $result = RoomTeacher::create([
                'teacher_id' => $this->selectedSubjectTeacher,
                'room_id' => $this->itemId
            ]);

            if ($result) {
                $this->notify('success', 'Add teacher successfull');
            } else {
                $this->notify('error', 'Add teacher fail');
            }
        }

        $this->setRoomTeacher();
        $this->setSubjectTeacher();
    }

    private function isRoomTeacherExist($teacherId) {
        $result = RoomTeacher::where('teacher_id', $teacherId)->where('room_id', $this->itemId)->exists();

        return $result;
    }

    private function isSubjectTeacherExist($teacherId) {
        $roomTeachersIds = RoomTeacher::selectColumns(['room_teachers.id'])
            ->where('room_id', $this->itemId)
            ->join('teachers', 'room_teachers.teacher_id', '=', 'teachers.id')
            ->where('teachers.subject_id', '=', DB::table('teachers')->where('id', $teacherId)->value('subject_id'))
            ->first();

        return $roomTeachersIds ? $roomTeachersIds->id : null;
    }

    public function save() {
        if(!$this->selectedTeacher) {
            $this->notify('error', 'You have not select homeroom teacher');
            return;
        }

        $result = Room::where('id', $this->itemId)->update(['homeroom_teacher_id' => $this->selectedTeacher]);

        if ($result) {
            $this->notify('success', 'Change homeroom teacher successfully');
        } else {
            $this->notify('error', 'Change homeroom teacher fail');
        }
    }

    public function deleteSubjectTeacher($id) {

        $result = RoomTeacher::where('id', $id)->delete();

        if ($result) {
            $this->notify('success', 'Remove teacher successfully');
        } else {
            $this->notify('error', 'Remove teacher fail');
        }

        $this->setRoomTeacher();
        $this->setSubjectTeacher();
    }

    public function deleteStudent($id)
    {
        $result = Student::where('id', $id)->update(['room_id' => null]);

        if ($result) {
            $this->notify('success', 'Remove teacher successfully');
        } else {
            $this->notify('error', 'Remove teacher fail');
        }

        $this->setStudent();
        $this->setRoomStudent();
    }
}
