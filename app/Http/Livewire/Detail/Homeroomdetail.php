<?php

namespace App\Http\Livewire\Detail;

use App\Constant\ExamType;
use App\Models\Exam;
use App\Models\Room;
use App\Models\RoomTeacher;
use App\Models\Student;
use App\Models\Subject;
use DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class Homeroomdetail extends Component
{
    use WithFileUploads;

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
            'grade_id'
        ])
        ->join('users', 'users.id', '=', 'rooms.homeroom_teacher_id')
        ->join('grades', 'grades.id', '=', 'rooms.grade_id')
        ->where('rooms.id', $this->itemId)
        ->first();

        $this->room = [
            'roomName' => $data->room_name,
            'teacherName' => $data->teacher_name,
            'teacherImage' => $data->teacher_image,
            'gradeId' => $data->grade_id
        ];

        $this->imageUrl = $data->room_image ?? asset('storage/images/default-image.png');
        $this->image = null;
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
                break;
            
            case self::BY_STUDENT:
                break;
            
            default:
                $this->setHeaderByTotalScore();
                $this->setBodyByTotalScore();
        }
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

    private function getSubjects() {
        $subjects = Subject::selectColumns([
            'id',
            'name',
            'coefficient'
        ])
        ->where('grade_id', $this->room['gradeId'])
        ->get();

        $data = [];

        foreach($subjects as $item) {
            $data[] = [
                'name' => $item->name,
                'value' => $item->id,
                'coefficient' => $item->coefficient
            ];
        }

        return $data;
    }

    private function getTotalScores($studentId) {
        $subjects = $this->header;

        $scores = [];

        $finalScore = 0;
        $totalCoeff = 0;
        foreach($subjects as $subject) {
            $exams = Exam::selectColumns([
                'score',
                'exams.type'
            ])
            ->join('exam_students', 'exam_students.exam_id', '=', 'exams.id')
            ->join('room_teachers', 'room_teachers.id', '=', 'exams.room_teacher_id')
            ->join('teachers', 'teachers.id', '=', 'room_teachers.teacher_id')
            ->where('exam_students.student_id', $studentId)
            ->where('teachers.subject_id', $subject['value'])
            ->get();

            $score = $this->getTotalScore($exams);
            $scores[] = $score;

            $finalScore += $score*$subject['coefficient'];
            $totalCoeff += $subject['coefficient'];
        }

        $scores[]  = $totalCoeff > 0 ? $finalScore / $totalCoeff : 0;

        return $scores;
    }

    private function getTotalScore($exams) {
        $totalScore = 0;
        $totalCoefficient = 0;

        foreach ($exams as $exam) {
            $coef = ExamType::COEFFICIENT[$exam->type];
            $totalCoefficient += $coef;
            $totalScore = $exam->score*$coef;
        }

        return $totalCoefficient > 0 ? $totalScore / $totalCoefficient : 0;
    }

    private function getStudents() {
        $students = Student::selectColumns([
            'students.id as student_id',
            'users.username as student_name',
            'users.image_url as student_image'
        ])
        ->join('users', 'users.id', '=', 'students.user_id')
        ->where('students.room_id', '=', $this->itemId)
        ->get();

        $data = [];

        foreach($students as $student) {
            $data[] = [
                'studentId' => $student->student_id,
                'studentName' => $student->student_name,
                'studentImage' => $student->student_image
            ];
        }

        
        return $data;
    }

    public function save()
    {
        $room = [];

        $room['image_url'] = $this->saveImage();

        $result = Room::where('id', $this->itemId)->update($room);

        if ($result) {
            $this->notify('success', 'Change room image successfully');
        } else {
            $this->notify('error', 'Change room image fail');
        }
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
    
    public function render()
    {
        return view('livewire.detail.homeroomdetail');
    }
}
