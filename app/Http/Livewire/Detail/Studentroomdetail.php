<?php

namespace App\Http\Livewire\Detail;

use App\Constant\ExamType;
use App\Constant\ExamTypeCoefficient;
use App\Constant\InsistenceTypes;
use App\Constant\NotificationStatus;
use App\Constant\UserRole;
use App\Http\Livewire\BaseComponent;
use App\Models\Exam;
use App\Models\Insistence;
use App\Models\Room;
use App\Models\RoomTeacher;
use App\Models\Student;
use App\Models\Subject;
use App\Models\User;
use App\Services\ConstantService;
use Auth;
use DB;

class Studentroomdetail extends BaseComponent
{
    const MAXNUMBERLENGTH = 0;

    const ALL = -1;

    public $room;

    public $itemId;

    public $roomTeachers;

    public $header;

    public $body;

    public $subjects;

    protected $constantService;

    public $student;

    public $rooms;

    public $selectedRoom;

    public $content;

    public function boot(ConstantService $constantService)
    {
        $this->constantService = $constantService;
    }

    public function mount($itemId)
    {
        $this->itemId = $itemId;
        $this->formGenerate();
        $this->setRoomTeacher();
    }

    public function formGenerate()
    {
        $data = Room::selectColumns([
            'rooms.image_url as room_image',
            DB::raw('CONCAT(grades.name, "", rooms.name) as room_name'),
            'users.username as teacher_name',
            'users.image_url as teacher_image',
            'rooms.grade_id',
            'school_years.name as school_year_name',
            'room_id',
        ])
            ->join('users', 'users.id', '=', 'rooms.homeroom_teacher_id')
            ->join('grades', 'grades.id', '=', 'rooms.grade_id')
            ->join('school_years', 'school_years.id', '=', 'rooms.school_year_id')
            ->join('students', 'students.room_id', '=', 'rooms.id')
            ->where('students.id', $this->itemId)
            ->first();

        $this->room = [
            'roomName' => $data->room_name,
            'teacherName' => $data->teacher_name,
            'teacherImage' => $data->teacher_image,
            'gradeId' => $data->grade_id,
            'schoolYearName' => $data->school_year_name,
            'roomImage' => $data->room_image,
            'roomId' => $data->room_id,
        ];

        $this->setHeader();
        $this->setBody();
        $this->setStudent();
        $this->selectedRoom = null;
        $this->content = '';
        $this->setRoom();
    }

    public function setRoom()
    {
        $room = Student::selectColumns([
            'school_year_id',
            'grade_id',
            'room_id',
        ])
            ->where('id', $this->itemId)
            ->first();

        $data = Room::selectColumns([
            'rooms.id',
            DB::raw('CONCAT(grades.name, "", rooms.name) as name'),
        ])
            ->join('grades', 'grades.id', '=', 'rooms.grade_id')
            ->where('grade_id', $room->grade_id)
            ->where('school_year_id', $room->school_year_id)
            ->whereNot('rooms.id', $room->room_id)
            ->get();

        $this->rooms = [];

        foreach ($data as $item) {
            $this->rooms[] = [
                'value' => $item->id,
                'name' => $item->name,
            ];
        }
    }

    public function requestChangeRoom()
    {
        if ($this->selectedRoom == null) {
            $this->notify('error', 'You have not select class to change');

            return;
        }

        if ($this->content == '') {
            $this->notify('error', 'Your content is empty');

            return;
        }

        try {
            $newRoom = Room::selectColumns([
                DB::raw('CONCAT(grades.name, "", rooms.name) as name'),
            ])
                ->join('grades', 'grades.id', '=', 'rooms.grade_id')
                ->where('rooms.id', $this->selectedRoom)->first();

            $newInsistence = Insistence::create([
                'user_id' => Auth::user()->id,
                'content' => 'I request for change room to '.$newRoom->name."\n - Detail: \n".$this->content,
                'status' => \App\Constant\Insistence::PENDING,
                'type' => InsistenceTypes::CHANGE_CLASS,
                'object' => json_encode(['roomId' => $this->selectedRoom]),
            ]);

            $admin = User::where('role', UserRole::ADMIN)->first();
            $newNotify = [
                'content' => 'You have new change class insistence',
                'from_user_id' => Auth::user()->id,
                'user_id' => $admin->id,
                'status' => NotificationStatus::UNSEEN,
                'link' => '/insistences/'.str($newInsistence->id),
            ];

            $this->realTimeNotify($newNotify);

            $this->notify('success', 'rescore request exam successfully');
        } catch (e) {
            $this->notify('error', 'rescore request exam fail');
        }
        $this->formGenerate();
    }

    public function setStudent()
    {
        $data = Student::selectColumns([
            'users.username as name',
            'users.image_url',
        ])
            ->join('users', 'users.id', '=', 'students.user_id')
            ->where('students.id', $this->itemId)
            ->first();

        $this->student = [
            'name' => $data->name,
            'image' => $data->image_url,
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

    private function setBody()
    {
        $subjects = $this->getSubjects();

        $subjectScores = [];
        foreach ($subjects as $subject) {
            $exams = $this->getExamBySubject($subject['value'], $this->itemId);
            $subjectScore = $this->getTotalScore($exams);

            $subjectScores[] = [
                'subject' => $subject,
                'scores' => $exams,
                'totalScore' => $subjectScore,
            ];
        }

        $scores = $this->getTotalScores($this->itemId);

        $this->body = [
            'subjectScores' => $subjectScores,
            'finalScore' => end($scores),
        ];
    }

    private function getSubjects()
    {
        $subjects = Subject::selectColumns([
            'id',
            'name',
            'coefficient',
            'image_url',
        ])
            ->where('grade_id', $this->room['gradeId'])
            ->get();

        $data = [];

        foreach ($subjects as $item) {
            $data[] = [
                'name' => $item->name,
                'value' => $item->id,
                'coefficient' => $item->coefficient,
                'image' => $item->image_url,
            ];
        }

        return $data;
    }

    private function getTotalScores($studentId)
    {
        $subjects = $this->getSubjects();

        $scores = [];

        $finalScore = 0;
        $totalCoeff = 0;
        foreach ($subjects as $subject) {
            $exams = $this->getExamBySubject($subject['value'], $studentId);

            $score = round($this->getTotalScore($exams), self::MAXNUMBERLENGTH);
            $scores[] = $score;

            $finalScore += $score * $subject['coefficient'];
            $totalCoeff += $subject['coefficient'];
        }

        $scores[] = $totalCoeff > 0 ? round($finalScore / $totalCoeff, self::MAXNUMBERLENGTH) : 0;

        return $scores;
    }

    private function getExamBySubject($subjectId, $studentId)
    {
        $exams = Exam::selectColumns([
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
            ->get();

        $data = [];

        foreach ($exams as $exam) {
            $data[] = [
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

    public function render()
    {
        return view('livewire.detail.studentroomdetail');
    }

    public function getModal($name, $data)
    {
        $this->displayModal($name, $data);
    }
}
