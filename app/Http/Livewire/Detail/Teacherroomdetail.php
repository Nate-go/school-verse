<?php

namespace App\Http\Livewire\Detail;

use App\Constant\ExamType;
use App\Constant\ExamTypeCoefficient;
use App\Constant\SortTypes;
use App\Constant\UserRole;
use App\Http\Livewire\BaseComponent;
use App\Models\Exam;
use App\Models\Room;
use App\Models\RoomTeacher;
use App\Models\Student;
use App\Services\ConstantService;
use Auth;
use DB;

class Teacherroomdetail extends BaseComponent
{
    const MAXNUMBERLENGTH = 0;

    const ALL = -1;

    public $room;

    public $itemId;

    public $roomTeachers;

    public $header;

    public $body;

    public $students;

    protected $constantService;

    public $teacher;

    public $examTypes;

    public $selectedExamType;

    public $selectedStudents;

    public $selectedExam;

    public $exams;

    public $isTeacher;

    protected $listeners = ['updateScore' => 'setBody', 'updateExamList' => 'formGenerate'];

    public function boot(ConstantService $constantService)
    {
        $this->constantService = $constantService;
    }

    public function mount($itemId)
    {
        $this->itemId = $itemId;
        $this->selectedStudent = [];
        $this->selectedExamType = self::ALL;
        $this->formGenerate();
        $this->setTeacher();
        $this->setRoomTeacher();

        $this->examTypes = $this->constantService->getConstantsJson(ExamType::class);
        $this->students = $this->getStudents();

        $this->selectedExam = null;
    }

    public function changeExam($value)
    {
        if ($this->selectedExam == $value) {
            $this->selectedExam = null;
        } else {
            $this->selectedExam = $value;
        }
    }

    public function formGenerate()
    {
        $this->isTeacher = Auth::user()->role == UserRole::TEACHER;
        $data = Room::selectColumns([
            'rooms.image_url as room_image',
            DB::raw('CONCAT(grades.name, "", rooms.name) as room_name'),
            'users.username as teacher_name',
            'users.image_url as teacher_image',
            'grade_id',
            'school_years.name as school_year_name',
            'rooms.id',
            'subject_id',
        ])
            ->join('users', 'users.id', '=', 'rooms.homeroom_teacher_id')
            ->join('grades', 'grades.id', '=', 'rooms.grade_id')
            ->join('school_years', 'school_years.id', '=', 'rooms.school_year_id')
            ->join('room_teachers', 'room_teachers.room_id', 'rooms.id')
            ->join('teachers', 'teachers.id', '=', 'room_teachers.teacher_id')
            ->where('room_teachers.id', $this->itemId)
            ->first();

        $this->room = [
            'roomName' => $data->room_name,
            'teacherName' => $data->teacher_name,
            'teacherImage' => $data->teacher_image,
            'gradeId' => $data->grade_id,
            'schoolYearName' => $data->school_year_name,
            'roomId' => $data->id,
            'subjectId' => $data->subject_id,
        ];

        $this->setHeader();
        $this->setBody();
        $this->setExam();
    }

    public function setExam()
    {
        $data = Exam::selectColumns([
            'id',
            'content',
            'type',
            DB::raw('(select count(id) from exam_students where exam_id = exams.id and deleted_at is null) as member'),
        ])
            ->where('room_teacher_id', $this->itemId)
            ->whereOrAll(['type'], [$this->selectedExamType])
            ->sort(['columnName' => 'created_at', 'type' => SortTypes::DECREASE_SORT])
            ->get();

        $this->exams = [];

        foreach ($data as $item) {
            $this->exams[] = [
                'id' => $item->id,
                'content' => $item->content,
                'type' => ['value' => $item->type, 'name' => $this->constantService->getNameConstant(ExamType::class, $item->type)],
                'member' => $item->member,
            ];
        }
    }

    public function updatedSelectedExamType($value)
    {
        $this->setExam();
    }

    public function setTeacher()
    {
        $data = RoomTeacher::selectColumns([
            'users.username as name',
            'users.image_url as image',
            'subjects.name as subject_name',
        ])
            ->join('teachers', 'teachers.id', '=', 'room_teachers.teacher_id')
            ->join('subjects', 'subjects.id', '=', 'teachers.subject_id')
            ->join('users', 'users.id', '=', 'teachers.user_id')
            ->where('room_teachers.id', $this->itemId)
            ->first();

        $this->teacher = [
            'name' => $data->name,
            'image' => $data->image,
            'subjectName' => $data->subject_name,
        ];
    }

    private function setRoomTeacher()
    {
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
            ->where('room_teachers.room_id', $this->room['roomId'])
            ->get();

        $this->roomTeachers = [];

        foreach ($roomTeachers as $roomTeacher) {
            $this->roomTeachers[] = [
                'subject' => $roomTeacher->subject_name,
                'value' => $roomTeacher->id,
                'email' => $roomTeacher->email,
                'name' => $roomTeacher->username,
                'image_url' => $roomTeacher->image_url,
            ];
        }
    }

    private function setHeader()
    {
        $this->header = $this->constantService->getConstantsJson(ExamType::class);
    }

    public function setBody()
    {
        $this->body = [];

        $students = $this->getStudents();

        foreach ($students as $student) {
            $exams = $this->getExamBySubject($this->room['subjectId'], $student['studentId']);
            $subjectScore = $this->getTotalScore($exams);

            $this->body[] = [
                'student' => $student,
                'scores' => $exams,
                'totalScore' => $subjectScore,
            ];
        }
    }

    private function getExamBySubject($subjectId, $studentId)
    {
        $exams = Exam::selectColumns([
            'exams.id as exam_id',
            'exam_students.id',
            'score',
            'exams.type',
            'subjects.name',
        ])
            ->join('exam_students', 'exam_students.exam_id', '=', 'exams.id')
            ->join('room_teachers', 'room_teachers.id', '=', 'exams.room_teacher_id')
            ->join('teachers', 'teachers.id', '=', 'room_teachers.teacher_id')
            ->join('subjects', 'subjects.id', '=', 'teachers.subject_id')
            ->where('exam_students.student_id', $studentId)
            ->where('teachers.subject_id', $subjectId)
            ->whereAllDeletedNull(['exam_students'])
            ->get();
        $data = [];

        foreach ($exams as $exam) {
            $data[] = [
                'examId' => $exam->exam_id,
                'id' => $exam->id,
                'score' => $exam->score,
                'type' => $exam->type,
                'name' => $exam->name,
            ];
        }

        return $data;
    }

    private function getTotalScore($exams)
    {
        $totalScore = 0;
        $totalCoefficient = 0;

        foreach ($exams as $exam) {
            $coef = ExamTypeCoefficient::COEFFICIENT[$exam['type']];
            $totalCoefficient += $coef;
            $totalScore += $exam['score'] * $coef;
        }

        return $totalCoefficient > 0 ? round($totalScore / $totalCoefficient, self::MAXNUMBERLENGTH) : 0;
    }

    private function getStudents()
    {
        $students = Student::selectColumns([
            'students.id as student_id',
            'users.username as student_name',
            'users.image_url as student_image',
        ])
            ->join('users', 'users.id', '=', 'students.user_id')
            ->where('students.room_id', '=', $this->room['roomId'])
            ->get();

        $data = [];

        foreach ($students as $student) {
            $data[] = [
                'studentId' => $student->student_id,
                'studentName' => $student->student_name,
                'studentImage' => $student->student_image,
            ];
        }

        return $data;
    }

    public function createExam($content)
    {
        if ($this->selectedExamType == null or $this->selectedExamType == -1) {
            $this->notify('error', 'Select an exam type before create');

            return;
        }

        $content = trim($content);
        if ($content == '') {
            $this->notify('error', 'Content can not be empty');

            return;
        }

        $exist = Exam::where('room_teacher_id', $this->itemId)
            ->where('content', $content)
            ->where('type', $this->selectedExamType)
            ->exists();

        if ($exist) {
            $this->notify('error', 'Content has exist in your exam list');

            return;
        }

        $newExam = Exam::create([
            'content' => $content,
            'room_teacher_id' => $this->itemId,
            'type' => $this->selectedExamType,
        ]);

        if ($newExam) {
            $this->notify('success', 'Create exam successfully');
        } else {
            $this->notify('error', 'Create exam fail');
        }

        $this->setExam();
    }

    private function getExamId()
    {
        $newExam = Exam::create([
            'room_teacher_id' => $this->itemId,
            'type' => $this->selectedExamType,
        ]);

        if ($newExam) {
            return $newExam->id;
        }
        $this->notify('error', 'Create exam fail');

        return null;
    }

    public function render()
    {
        return view('livewire.detail.teacherroomdetail');
    }

    public function getModal($name, $data)
    {
        $this->displayModal($name, $data);
    }
}
