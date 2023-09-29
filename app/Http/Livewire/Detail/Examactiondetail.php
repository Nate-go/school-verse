<?php

namespace App\Http\Livewire\Detail;

use App\Constant\NotificationStatus;
use App\Constant\OtherConstant;
use App\Constant\UserRole;
use App\Models\Exam;
use App\Models\ExamStudent;
use App\Models\Student;
use Auth;
use DB;
use League\Csv\Reader;
use Livewire\WithFileUploads;
use LivewireUI\Modal\ModalComponent;

class Examactiondetail extends ModalComponent
{
    use WithFileUploads;

    public $csvFile;

    public $exam;

    public $roomTeacherId;

    public $content;

    public $body;

    public $currentData;

    public $studentInRooms;

    public $selectedStudent;

    public $debug;

    public $enable;

    public $isTeacher;

    public function mount($exam, $roomTeacherId)
    {
        $this->exam = $exam;
        $this->roomTeacherId = $roomTeacherId;
        $this->formGenerate();
    }

    public function formGenerate()
    {
        $this->isTeacher = Auth::user()->role == UserRole::TEACHER;
        $this->content = $this->exam['content'];
        $this->setBody();
        $this->currentData = $this->body;
        $this->setStudentInRoom();
        $this->selectedStudent = null;
        $this->csvFile = null;
        $this->enable = $this->isEnable();
    }

    private function isEnable()
    {

        $startTime = Exam::selectColumns(['created_at'])
            ->where('id', $this->exam['id'])
            ->first();

        $createdTimestamp = strtotime($startTime->created_at);
        $currentTimestamp = time();

        return $currentTimestamp - $createdTimestamp <= OtherConstant::LIMIT_TIME_SECOND;
    }

    public function import()
    {
        if (! $this->enable) {
            $this->notify('error', 'Overtime to change anything');

            return;
        }

        if (! $this->csvFile) {
            $this->notify('error', 'You have not import file yet');

            return;
        }
        $csv = Reader::createFromPath($this->csvFile->getRealPath(), 'r');
        $csv->setHeaderOffset(0);
        $headers = $csv->getHeader();

        if (! $this->isValidHeaders($headers)) {
            return;
        }

        foreach ($this->body as &$item) {
            $success = false;
            foreach ($csv as $record) {
                if ($record['Name'] === $item['studentName']) {
                    $item['score'] = $record['Score'];
                    $item['review'] = $record['Review'];
                    $success = true;
                    break;
                }
            }
            $item['isMissing'] = ! $success;
        }
    }

    public function isValidHeaders($headers)
    {
        $expectedHeaders = ['Name', 'Score', 'Review'];
        $missingHeaders = [];

        foreach ($expectedHeaders as $expectedHeader) {
            if (! in_array($expectedHeader, $headers)) {
                $missingHeaders[] = $expectedHeader;
            }
        }
        if (empty($missingHeaders)) {
            return true;
        }
        $this->notify('error', 'Missing the following columns: '.implode(', ', $missingHeaders));

        return false;
    }

    public function setBody()
    {
        $students = Student::selectColumns([
            'students.id as student_id',
            'users.username as student_name',
            'users.image_url as student_image',
            'score',
            'review',
            'exam_students.id as exam_id',
            'user_id',
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
                'score' => $student->score,
                'examStudentId' => $student->exam_id,
                'review' => $student->review,
                'isMissing' => false,
                'userId' => $student->user_id,
            ];
        }
    }

    public function setStudentInRoom()
    {
        $students = Student::selectColumns([
            'students.id as student_id',
            'users.username as student_name',
            'users.image_url as student_image',
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
                'studentImage' => $student->student_image,
            ];
        }
    }

    public function save()
    {
        if (! $this->enable) {
            $this->notify('error', 'Overtime to change anything');

            return;
        }

        $this->saveContent();

        $this->saveScore();

        $this->formGenerate();
    }

    public function close()
    {
        $this->closeModalWithEvents([
            Teacherroomdetail::getName() => 'updateExamList',
            Teacherroomdetail::getName() => 'updateScore',
        ]);
    }

    public function updatedSelectedStudent($value)
    {
        if (! $this->enable) {
            $this->notify('error', 'Overtime to change anything');

            return;
        }

        $success = false;
        if ($this->selectedStudent != -1) {
            $success = $this->addStudentInExam($this->selectedStudent);
        } else {
            foreach ($this->studentInRooms as $student) {
                $result = $this->addStudentInExam($student['studentId']);

                if ($result) {
                    $success = true;
                }
            }
        }

        if ($success) {
            $this->notify('success', 'This student(s) have add to exam');
        } else {
            $this->notify('error', 'This student have exist in exam');
        }
        $this->formGenerate();
    }

    public function addStudentInExam($studentId)
    {
        if (! $this->enable) {
            $this->notify('error', 'Overtime to change anything');

            return;
        }

        if ($this->isExistInExam($studentId)) {
            return false;
        }

        $examStudent = ExamStudent::onlyTrashed()
            ->where('student_id', $studentId)
            ->where('exam_id', $this->exam['id'])
            ->first();

        if ($examStudent) {
            $examStudent->restore();
            $examStudent->score = 0;
            $examStudent->save();
        } else {
            ExamStudent::create([
                'student_id' => $studentId,
                'exam_id' => $this->exam['id'],
                'score' => 0,
                'review' => '',
            ]);
        }

        return true;
    }

    public function deleteStudent($studentId)
    {
        if (! $this->enable) {
            $this->notify('error', 'Overtime to change anything');

            return;
        }

        ExamStudent::where('student_id', $studentId)
            ->where('exam_id', $this->exam['id'])
            ->delete();

        $this->notify('success', 'Delete student successfully');
        $this->formGenerate();
    }

    public function isExistInExam($studentId)
    {
        foreach ($this->currentData as $examStudent) {
            if ($examStudent['studentId'] == $studentId) {
                return true;
            }
        }

        return false;
    }

    public function saveScore()
    {
        $updateExams = [];
        for ($i = 0; $i < count($this->body); $i++) {
            if ($this->body[$i]['score'] != $this->currentData[$i]['score'] or $this->body[$i]['review'] != $this->currentData[$i]['review']) {
                $updateExams[] = $this->body[$i];
            }
        }
        $success = $this->updateScore($updateExams);

        if ($success) {
            $this->notify('success', 'Update scores successfully');
            $this->notifyForUpdateScore($updateExams);

            return;
        }
        $this->notify('error', 'Update scores fail');
    }

    public function notifyForUpdateScore($updateExams)
    {
        foreach ($updateExams as $updateExam) {
            $newNotify = [
                'content' => 'Your '.$this->exam['name'].' score has been updated',
                'from_user_id' => Auth::user()->id,
                'user_id' => $updateExam['userId'],
                'status' => NotificationStatus::UNSEEN,
                'link' => '/',
            ];

            $this->realTimeNotify($newNotify);
        }
    }

    public function updateScore($exams)
    {

        $success = false;
        DB::transaction(function () use ($exams, &$success) {
            foreach ($exams as $exam) {
                ExamStudent::where('id', $exam['examStudentId'])
                    ->update([
                        'score' => min(intval($exam['score']), 100),
                        'review' => $exam['review'],
                    ]);
            }

            $success = true;
        });

        return $success;
    }

    public function saveContent()
    {
        if (! $this->enable) {
            $this->notify('error', 'Overtime to change anything');

            return;
        }

        $this->content = trim($this->content);
        if ($this->content == '') {
            $this->notify('error', 'Content can not be empty');

            return;
        }

        $exist = Exam::whereNot('id', $this->exam['id'])
            ->where('room_teacher_id', $this->roomTeacherId)
            ->where('content', $this->content)
            ->where('type', $this->exam['type']['value'])
            ->exists();

        if ($exist) {
            $this->notify('error', 'Content has exist in your exam list');

            return;
        }

        $result = Exam::where('id', $this->exam['id'])
            ->update(['content' => $this->content]);

        if ($result) {
            $this->notify('success', 'Content change successfully');

            return;
        }
        $this->notify('error', 'Content change fail');
    }

    public function delete()
    {
        if ($this->exam['member'] > 0) {
            $this->notify('error', 'Have '.str($this->exam['member']).' student done this exam you can not delete');

            return;
        }

        $result = Exam::where('id', $this->exam['id'])
            ->delete();

        if ($result) {
            $this->notify('success', 'Delete exam successfully');
            $this->closeModalWithEvents([
                Teacherroomdetail::getName() => 'updateExamList',
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
