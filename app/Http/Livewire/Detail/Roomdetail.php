<?php

namespace App\Http\Livewire\Detail;

use App\Constant\NotificationStatus;
use App\Constant\UserRole;
use App\Models\Room;
use App\Models\RoomTeacher;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Auth;
use DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class Roomdetail extends Component
{
    use WithFileUploads;
    
    public $schoolYear;

    public $image;

    public $imageUrl;

    public $gradeId;

    public $schoolYearId;

    public $name;

    public $grade;

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
            'users.image_url',
            'users.id as user_id'
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
                'image_url' => $roomStudent->image_url,
                'userId' => $roomStudent->user_id
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
            'rooms.name as room_name',
            'rooms.image_url as image_url',
            'school_years.name as school_year',
            'grades.id as grade_id',
            'rooms.school_year_id',
            'grades.name as grade_name'
        )
            ->join('grades', 'rooms.grade_id', '=', 'grades.id')
            ->join('school_years', 'rooms.school_year_id', '=', 'school_years.id')
            ->where('rooms.id', $this->itemId)->first();

        $this->schoolYear = $data->school_year;
        $this->imageUrl = $data->image_url;
        $this->name = $data->room_name;
        $this->gradeId = $data->grade_id;
        $this->schoolYearId = $data->school_year_id;
        $this->grade = $data->grade_name;

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
            $this->notifyForAddStudent();
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

        $subject = Teacher::selectColumns(['subject_id'])
            ->where('id', $this->selectedSubjectTeacher)
            ->first();

        $currentRoomTeacher = RoomTeacher::selectColumns(['room_teachers.id'])
            ->join('teachers', 'teachers.id', '=', 'room_teachers.teacher_id')
            ->where('teachers.subject_id', $subject->subject_id)
            ->where('room_id', $this->itemId)
            ->whereAllDeletedNull(['teachers'])
            ->first();

        if ($currentRoomTeacher) {
            RoomTeacher::where('id', $currentRoomTeacher->id)
                ->delete();
        }

        $roomTeacher = RoomTeacher::onlyTrashed()
            ->where('room_id', $this->itemId)
            ->where('teacher_id', $this->selectedSubjectTeacher)
            ->first();

        if ($roomTeacher) {
            $roomTeacher->restore();
            $roomTeacher->save();
        } else {
            $result = RoomTeacher::create([
                'teacher_id' => $this->selectedSubjectTeacher,
                'room_id' => $this->itemId
            ]);

            if ($result) {
                $this->notify('success', 'Add teacher successfull');
                $this->notifyForAddTeacher();
            } else {
                $this->notify('error', 'Add teacher fail');
            }
        }

        $this->setRoomTeacher();
        $this->setSubjectTeacher();
    }

    public function notifyForAddStudent() {
        $student = Student::where('id', $this->selectedStudent)->first();
        $newNotify = [
            'content' => 'You have been changed class to ' . $this->grade . $this->name,
            'from_user_id' => Auth::user()->id,
            'user_id' => $student->user_id,
            'status' => NotificationStatus::UNSEEN,
            'link' => '/'
        ];

        $this->realTimeNotify($newNotify);

        $room = Room::where('id', $this->itemId)->first();
        $newNotify = [
            'content' => 'A new student has been add to your class: ' . $this->grade . $this->name,
            'from_user_id' => Auth::user()->id,
            'user_id' => $room->homeroom_teacher_id,
            'status' => NotificationStatus::UNSEEN,
            'link' => '/rooms/' . str($this->itemId)
        ];

        $this->realTimeNotify($newNotify);
    }

    public function notifyForAddTeacher()
    {
        $teacher = Teacher::where('id', $this->selectedSubjectTeacher)->first();
        $roomTeacher = RoomTeacher::where('room_id', $this->itemId)
                                ->where('teacher_id', $this->selectedSubjectTeacher)
                                ->first();
        $newNotify = [
            'content' => 'You have been add to class ' . $this->grade . $this->name,
            'from_user_id' => Auth::user()->id,
            'user_id' => $teacher->user_id,
            'status' => NotificationStatus::UNSEEN,
            'link' => '/teachers/room-teachers/' . str($roomTeacher->id)
        ];

        $this->realTimeNotify($newNotify);

        foreach($this->roomStudents as $student) {
            $room = Room::where('id', $this->itemId)->first();
            $newNotify = [
                'content' => 'A new teacher has been add to your class: ' . $this->grade . $this->name,
                'from_user_id' => Auth::user()->id,
                'user_id' => $student['userId'],
                'status' => NotificationStatus::UNSEEN,
                'link' => '/students/' . str($student['userId']) . '/rooms' . str($this->itemId)
            ];

            $this->realTimeNotify($newNotify);
        }

        $room = Room::where('id', $this->itemId)->first();
        $newNotify = [
            'content' => 'A new teacher has been add to your class: ' . $this->grade . $this->name,
            'from_user_id' => Auth::user()->id,
            'user_id' => $room->homeroom_teacher_id,
            'status' => NotificationStatus::UNSEEN,
            'link' => '/teachers/room-teachers/' . str($this->itemId)
        ];

        $this->realTimeNotify($newNotify);
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

        $oldRoom = Room::where('id', $this->itemId)->first();

        $room = [
            'homeroom_teacher_id' => $this->selectedTeacher,
            'name' => $this->name,
        ];

        $result = $this->isValidData($room);

        if (!$result['isValid']) {
            $this->notify('error', $result['message']);

            return;
        }

        $room['image_url'] = $this->saveImage();

        $result = Room::where('id', $this->itemId)->update($room);

        if ($result) {
            $this->notify('success', 'Change room detail successfully');
            $currentRoom = Room::where('id', $this->itemId)->first();

            if($oldRoom->image_url != $currentRoom->image_url) {
                $this->notifyForChangeImage();
            }

            if ($oldRoom->homeroom_teacher_id != $currentRoom->homeroom_teacher_id) {
                $this->notifyForChangeHomeroomTeacher();
            }

            if ($oldRoom->name != $currentRoom->name) {
                $this->notifyForChangeName();
            }

        } else {
            $this->notify('error', 'Change room detail fail');
        }
    }

    public function notifyForChangeImage() {
        $room = Room::where('id', $this->itemId)->first();
        $newNotify = [
            'content' => 'Image of your class ' . $this->grade . $this->name . ' has been changed',
            'from_user_id' => Auth::user()->id,
            'user_id' => $room->homeroom_teacher_id,
            'status' => NotificationStatus::UNSEEN,
            'link' => '/teachers/homerooms/' . str($this->itemId)
        ];

        $this->realTimeNotify($newNotify);

        foreach ($this->roomStudents as $student) {
            $room = Room::where('id', $this->itemId)->first();
            $newNotify = [
                'content' => 'Image of your class ' . $this->grade . $this->name . ' has been changed',
                'from_user_id' => Auth::user()->id,
                'user_id' => $student['userId'],
                'status' => NotificationStatus::UNSEEN,
                'link' => '/students/' . str($student['userId']) . '/rooms' . str($this->itemId)
            ];

            $this->realTimeNotify($newNotify);
        }
    }

    public function notifyForChangeName()
    {
        $room = Room::where('id', $this->itemId)->first();
        $newNotify = [
            'content' => 'Name of your class ' . $this->grade . $this->name . ' has been changed',
            'from_user_id' => Auth::user()->id,
            'user_id' => $room->homeroom_teacher_id,
            'status' => NotificationStatus::UNSEEN,
            'link' => '/teachers/homerooms/' . str($this->itemId)
        ];

        $this->realTimeNotify($newNotify);

        foreach ($this->roomStudents as $student) {
            $room = Room::where('id', $this->itemId)->first();
            $newNotify = [
                'content' => 'Name of your class ' . $this->grade . $this->name . ' has been changed',
                'from_user_id' => Auth::user()->id,
                'user_id' => $student['userId'],
                'status' => NotificationStatus::UNSEEN,
                'link' => '/students/' . str($student['userId']) . '/rooms' . str($this->itemId)
            ];

            $this->realTimeNotify($newNotify);
        }
    }

    public function notifyForChangeHomeroomTeacher()
    {
        foreach ($this->roomStudents as $student) {
            $room = Room::where('id', $this->itemId)->first();
            $newNotify = [
                'content' => 'Homeroom teacher of your class ' . $this->grade . $this->name . ' has been changed',
                'from_user_id' => Auth::user()->id,
                'user_id' => $student['userId'],
                'status' => NotificationStatus::UNSEEN,
                'link' => '/students/' . str($student['userId']) . '/rooms' . str($this->itemId)
            ];

            $this->realTimeNotify($newNotify);
        }
    }

    private function isValidData($data) {
        if ($data['name'] === '') {
            return ['isValid' => false, 'message' => 'Name is invalid'];
        }

        if (!$data['homeroom_teacher_id']) {
            return ['isValid' => false, 'message' => 'Homeroom teacher have not been selected'];
        }

        $nameExists = Room::where('grade_id', $this->gradeId)
            ->where('name', $data['name'])
            ->where('school_year_id', $this->schoolYearId)
            ->where('id', '<>', $this->itemId)
            ->exists();

        if ($nameExists) {
            return ['isValid' => false, 'message' => 'This room name has been exist'];
        }

        return ['isValid' => true];
    }

    public function saveImage()
    {
        if ($this->image) {
            $imageName = time() . '.' . $this->image->extension();
            $this->image->storeAs('public/images', $imageName);
            $url = asset('storage/images/' . $imageName);

            return $url;
        } else {
            return $this->imageUrl;
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
