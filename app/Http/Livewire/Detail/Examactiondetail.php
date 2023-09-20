<?php

namespace App\Http\Livewire\Detail;

use App\Models\Exam;
use App\Models\Student;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class Examactiondetail extends ModalComponent
{
    public $exam;

    public $roomTeacherId;

    public $content;

    public $body;

    public $studentInRooms;

    public $seletedStudent;

    public $debug;

    public function mount($exam, $roomTeacherId) {
        $this->exam = $exam;
        $this->roomTeacherId = $roomTeacherId;
        $this->formGenerate();
    }

    public function formGenerate() {
        $this->content = $this->exam['content'];
        $this->setBody();
        $this->setStudentInRoom();
        $this->seletedStudent = null;
    }

    public function setBody() {
        $students = Student::selectColumns([
            'students.id as student_id',
            'users.username as student_name',
            'users.image_url as student_image',
            'score'
        ])
            ->join('users', 'users.id', '=', 'students.user_id')
            ->join('exam_students', 'exam_students.student_id', '=', 'students.id')
            ->join('exams', 'exams.id', '=', 'exam_students.exam_id')
            ->where('exams.id', '=', $this->exam['id'])
            ->whereAllDeletedNull(['users', 'exam_students', 'exams'])
            ->get();

        $this->body = [];

        foreach ($students as $student) {
            $this->body[] = [
                'studentId' => $student->student_id,
                'studentName' => $student->student_name,
                'studentImage' => $student->student_image,
                'score' => $student->score
            ];
        }
    }

    public function setStudentInRoom() {
        $students = Student::selectColumns([
            'students.id as student_id',
            'users.username as student_name',
            'users.image_url as student_image'
        ])
            ->join('users', 'users.id', '=', 'students.user_id')
            ->join('room_teachers', 'room_teachers.room_id', '=', 'students.room_id')
            ->where('room_teachers.id', '=', $this->roomTeacherId)
            ->whereAllDeletedNull(['users', 'room_teachers'])
            ->get();

        $this->studentInRooms = [];

        foreach ($students as $student) {
            $this->studentInRooms[] = [
                'studentId' => $student->student_id,
                'studentName' => $student->student_name,
                'studentImage' => $student->student_image
            ];
        }
    }

    public function save() {
        $this->content = trim($this->content);
        if($this->content == '') {
            $this->notify('error', 'Content can not be empty');
            return;
        }

        $exist = Exam::whereNot('id', $this->exam['id'])
                        ->where('room_teacher_id', $this->roomTeacherId)
                        ->where('content', $this->content)
                        ->where('type', $this->exam['type']['value'])
                        ->exists();
        
        if($exist) {
            $this->notify('error', 'Content has exist in your exam list');
            return;
        }

        $result = Exam::where('id', $this->exam['id'])
                        ->update(['content' => $this->content]);

        if ($result) {
            $this->notify('success', 'Content change successfully');
            $this->closeModalWithEvents([
                Teacherroomdetail::getName() => 'updateExamList'
            ]);
            return;
        }
        $this->notify('error', 'Content change fail');
    }

    public function delete() {
        if($this->exam['member'] > 0) {
            $this->notify('error', 'Have ' . str($this->exam['member']) . ' student done this exam you can not delete');
            return;
        }

        $result = Exam::where('id', $this->exam['id'])
            ->delete();

        if ($result) {
            $this->notify('success', 'Delete exam successfully');
            $this->closeModalWithEvents([
                Teacherroomdetail::getName() => 'updateExamList'
            ]);
            return;
        }
        $this->notify('error', 'Delete exam fail');
    }

    public function render()
    {
        return view('livewire.detail.examactiondetail');
    }
}
