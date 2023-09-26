<?php

namespace App\Http\Livewire\Detail;

use App\Constant\ExamType;
use App\Constant\ExamTypeCoefficient;
use App\Models\Exam;
use App\Models\Room;
use App\Models\RoomTeacher;
use App\Models\Student;
use App\Models\Subject;
use App\Services\ConstantService;
use Auth;
use DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class Homeroomdetail extends Component
{
    use WithFileUploads;

    const MAXNUMBERLENGTH = 0;

    public $image;

    public $imageUrl;

    public $room;

    public $itemId;

    public $roomTeachers;

    const TOTAL_SCORE = 0;

    const BY_SUBJECT = 1;

    const BY_STUDENT = 2;

    public $typeViews;

    public $selectedTypeView;

    public $header;

    public $body;

    public $subjects;

    public $selectedSubject;

    public $students;

    public $selectedStudent;

    public $studentName;

    protected $constantService;

    public function boot(ConstantService $constantService) {
        $this->constantService = $constantService;
    }

    public function mount($itemId) {
        $this->itemId = $itemId;
        $this->formGenerate();
        $this->setRoomTeacher();
        $this->typeViews = [
            ['name' => 'Total score', 'value' => self::TOTAL_SCORE],
            ['name' => 'By subject', 'value' => self::BY_SUBJECT],
            ['name' => 'By student', 'value' => self::BY_STUDENT]
        ];

        $this->selectedTypeView = self::TOTAL_SCORE;

        $this->setDataTable();
    }

    public function formGenerate() {
        $data = Room::selectColumns([
            'rooms.image_url as room_image',
            DB::raw('CONCAT(grades.name, "", rooms.name) as room_name'),
            'users.username as teacher_name',
            'users.image_url as teacher_image',
            'grade_id',
            'school_years.name as school_year_name'
        ])
        ->join('users', 'users.id', '=', 'rooms.homeroom_teacher_id')
        ->join('grades', 'grades.id', '=', 'rooms.grade_id')
        ->join('school_years', 'school_years.id', '=', 'rooms.school_year_id')
        ->where('rooms.id', $this->itemId)
        ->first();

        $this->room = [
            'roomName' => $data->room_name,
            'teacherName' => $data->teacher_name,
            'teacherImage' => $data->teacher_image,
            'gradeId' => $data->grade_id,
            'schoolYearName' => $data->school_year_name
        ];

        $this->imageUrl = $data->room_image ?? asset('storage/images/default-image.png');
        $this->image = null;

        $this->updateTypeViewData();
    }

    private function updateTypeViewData() {
        $this->subjects = $this->getSubjects();
        $this->students = $this->getStudents();

        $this->selectedStudent = null;
        $this->selectedSubject = null;
        $this->studentName = '';
    }

    public function updatedSelectedTypeView($value) {
        $this->updateTypeViewData();
        $this->setDataTable();
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

        foreach ($roomTeachers as $roomTeacher) {
            $this->roomTeachers[] = [
                'subject' => $roomTeacher->subject_name,
                'value' => $roomTeacher->id,
                'email' => $roomTeacher->email,
                'name' => $roomTeacher->username,
                'image_url' => $roomTeacher->image_url
            ];
        }
    }

    public function setDataTable() {
        switch($this->selectedTypeView) {
            case self::BY_SUBJECT:
                $this->setHeaderBySubject();
                $this->setBodyBySubject();
                break;
            
            case self::BY_STUDENT:
                $this->setHeaderByStudent();
                $this->setBodyByStudent();
                break;
            
            default:
                $this->setHeaderByTotalScore();
                $this->setBodyByTotalScore();
        }
    }

    private function setHeaderByStudent() {
        $this->header = $this->constantService->getConstantsJson(ExamType::class);
    }

    private function setBodyByStudent() {

        $subjects = $this->getSubjects();

        $subjectScores = [];
        foreach($subjects as $subject) {
            $exams = $this->getExamBySubject($subject['value'], $this->selectedStudent);
            $subjectScore = $this->getTotalScore($exams);

            $subjectScores[] = [
                'subject' => $subject,
                'scores' => $exams,
                'totalScore' => $subjectScore
            ];
        }

        $scores = $this->getTotalScores($this->selectedStudent);

        $this->body = [
            'subjectScores' => $subjectScores,
            'finalScore' => end($scores)
        ];
    }

    private function setHeaderBySubject() {
        $this->header = $this->constantService->getConstantsJson(ExamType::class);
    }

    private function setBodyBySubject() {
        $this->body = [];

        $students = $this->getStudents();

        foreach($students as $student) {
            $exams = $this->getExamBySubject($this->selectedSubject, $student['studentId']);
            $subjectScore = $this->getTotalScore($exams);

            $this->body[] = [
                'student' => $student,
                'scores' => $exams,
                'totalScore' => $subjectScore
            ];
        }
    }

    public function updatedSelectedSubject() {
        $this->setBodyBySubject();
    }

    private function setHeaderByTotalScore() {
        $this->header = $this->getSubjects();
    }

    private function setBodyByTotalScore() {
        $students = $this->getStudents();

        $this->body = [];

        foreach($students as $student) {
            $this->body[] = [
                'student' => $student,
                'totalScores' => $this->getTotalScores($student['studentId'])
            ];
        }
    }

    public function updatedSelectedStudent() {
        $this->setBodyByStudent();
    }

    public function updatedStudentName() {
        $this->students = $this->getStudents();

        foreach($this->students as $student) {
            if($student['studentId'] == $this->selectedStudent) {
                return;
            }
        }

        $this->selectedStudent = null;
    }

    private function getSubjects() {
        $subjects = Subject::selectColumns([
            'id',
            'name',
            'coefficient',
            'image_url'
        ])
        ->where('grade_id', $this->room['gradeId'])
        ->get();

        $data = [];

        foreach($subjects as $item) {
            $data[] = [
                'name' => $item->name,
                'value' => $item->id,
                'coefficient' => $item->coefficient,
                'image' =>$item->image_url
            ];
        }

        return $data;
    }

    private function getTotalScores($studentId) {
        $subjects = $this->getSubjects();

        $scores = [];

        $finalScore = 0;
        $totalCoeff = 0;
        foreach($subjects as $subject) {
            $exams = $this->getExamBySubject($subject['value'], $studentId);

            $score = round($this->getTotalScore($exams), self::MAXNUMBERLENGTH);
            $scores[] = $score;

            $finalScore += $score*$subject['coefficient'];
            $totalCoeff += $subject['coefficient'];
        }

        $scores[]  = $totalCoeff > 0 ? round($finalScore / $totalCoeff, self::MAXNUMBERLENGTH) : 0;

        return $scores;
    }

    private function getExamBySubject($subjectId, $studentId) {
        $exams = Exam::selectColumns([
            'exam_students.id',
            'score',
            'exams.type',
            'subjects.name'
        ])
            ->join('exam_students', 'exam_students.exam_id', '=', 'exams.id')
            ->join('room_teachers', 'room_teachers.id', '=', 'exams.room_teacher_id')
            ->join('teachers', 'teachers.id', '=', 'room_teachers.teacher_id')
            ->join('subjects', 'subjects.id', '=', 'teachers.subject_id')
            ->where('exam_students.student_id', $studentId)
            ->where('teachers.subject_id', $subjectId)
            ->get();

        $data = [];

        foreach($exams as $exam) {
            $data[] = [
                'id' => $exam->id,
                'score' => $exam->score,
                'type' => $exam->type,
                'name' => $exam->name
            ];
        }

        return $data;
    }

    private function getTotalScore($exams) {
        $totalScore = 0;
        $totalCoefficient = 0;

        foreach ($exams as $exam) {
            $coef = ExamTypeCoefficient::COEFFICIENT[$exam['type']];
            $totalCoefficient += $coef;
            $totalScore += $exam['score']*$coef;
        }

        return $totalCoefficient > 0 ? round($totalScore / $totalCoefficient, self::MAXNUMBERLENGTH) : 0;
    }

    private function getStudents() {
        $students = Student::selectColumns([
            'students.id as student_id',
            'users.username as student_name',
            'users.image_url as student_image',
            'users.id as user_id'
        ])
        ->join('users', 'users.id', '=', 'students.user_id')
        ->where('students.room_id', '=', $this->itemId)
        ->contain('users.username', $this->studentName)
        ->get();

        $data = [];

        foreach($students as $student) {
            $data[] = [
                'studentId' => $student->student_id,
                'studentName' => $student->student_name,
                'studentImage' => $student->student_image,
                'userId' => $student->user_id,
            ];
        }

        
        return $data;
    }

    public function save() {
        
        $room = [];

        $room['image_url'] = $this->saveImage();

        $result = Room::where('id', $this->itemId)->update($room);

        if ($result) {
            $this->notify('success', 'Change room image successfully');
            if($room['image_url'] != $this->imageUrl) {
                $this->notifyForChangeImage();
            }
        } else {
            $this->notify('error', 'Change room image fail');
        }
    }

    public function notifyForChangeImage() {
        $this->studentName = '';
        $students = $this->getStudents();

        foreach($students as $student) {
            $room = Room::where('id', $this->itemId)->first();
            $newNotify = [
                'content' => 'Image of your class ' . $this->room['roomName'] . ' has been changed',
                'from_user_id' => Auth::user()->id,
                'user_id' => $student['userId'],
                'status' => NotificationStatus::UNSEEN,
                'link' => '/students/' . str($student['userId']) . '/rooms' . str($this->itemId)
            ];

            $this->realTimeNotify($newNotify);
        }
    }

    public function saveImage() {
        if ($this->image) {
            $imageName = time() . '.' . $this->image->extension();
            $this->image->storeAs('public/images', $imageName);
            $url = asset('storage/images/' . $imageName);

            return $url;
        } else {
            return $this->imageUrl;
        }
    }

    public function changeToSubjectView($subjectId) {
        $this->selectedTypeView = self::BY_SUBJECT;

        $this->selectedSubject = $subjectId;

        $this->setDataTable();
    }

    public function changeToStudentView($studentId) {
        $this->selectedTypeView = self::BY_STUDENT;

        $this->selectedStudent = $studentId;

        $this->studentName = '';

        $this->setDataTable();
    }
    
    public function render()
    {
        return view('livewire.detail.homeroomdetail');
    }
}
