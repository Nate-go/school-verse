<?php

namespace Tests\Unit\Services\ModelServices\ExamServiceTest;

use App\Constant\ExamType;
use App\Constant\UserRole;
use App\Constant\UserStatus;
use App\Models\Exam;
use App\Models\ExamStudent;
use App\Models\Grade;
use App\Models\Profile;
use App\Models\Room;
use App\Models\RoomTeacher;
use App\Models\SchoolYear;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use App\Services\ModelServices\ExamService;
use Illuminate\Contracts\View\View;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery\MockInterface;

class ExamServiceTest extends TestCase
{
    use RefreshDatabase;

    public function testAdminCanAccessPage()
    {
        $data = $this->setUpInitData();

        $examService = app()->make(ExamService::class);
        $this->be($data['admin']);
        $result = $examService->getRescorePage($data['examStudentRescoreable']->id);

        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('teacher.exam.rescore', $result->getName());

        $viewData = $result->getData();

        $this->assertEquals($data['examStudentRescoreable']->id, $viewData['examStudentId']);
    }

    public function testTrueTeacherCanAccessPage()
    {
        $data = $this->setUpInitData();

        $examService = app()->make(ExamService::class);
        $this->be($data['teacher']);
        $result = $examService->getRescorePage($data['examStudentRescoreable']->id);

        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('teacher.exam.rescore', $result->getName());

        $viewData = $result->getData();

        $this->assertEquals($data['examStudentRescoreable']->id, $viewData['examStudentId']);
    }

    public function testFalseTeacherCanNotAccessPage()
    {
        $data = $this->setUpInitData();

        $examService = app()->make(ExamService::class);
        $this->be($data['otherTeacher']);
        $result = $examService->getRescorePage($data['examStudentRescoreable']->id);

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $result);

        $this->assertEquals(route('notFound'), $result->getTargetUrl());
    }

    public function testStudentCanNotAccessPage()
    {
        $data = $this->setUpInitData();

        $examService = app()->make(ExamService::class);
        $this->be($data['student']);
        $result = $examService->getRescorePage($data['examStudentRescoreable']->id);

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $result);

        $this->assertEquals(route('notFound'), $result->getTargetUrl());
    }

    public function testRescoreableNotOpenYetCanNotAccessPage()
    {
        $data = $this->setUpInitData();

        $examService = app()->make(ExamService::class);
        $this->be($data['admin']);
        $result = $examService->getRescorePage($data['examStudent']->id);

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $result);

        $this->assertEquals(route('notFound'), $result->getTargetUrl());
    }

    public function testRescoreableIsClosedCanNotAccessPage()
    {
        $data = $this->setUpInitData();

        $examService = app()->make(ExamService::class);
        $this->be($data['admin']);
        $result = $examService->getRescorePage($data['examStudentRescoreableClose']->id);

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $result);

        $this->assertEquals(route('notFound'), $result->getTargetUrl());
    }

    public function setUpInitData()
    {
        $data = [];

        $adminData = [
            'email' => 'admin@gmail.com',
            'password' => '123456',
            'role' => UserRole::ADMIN,
            'status' => UserStatus::ACTIVE,
            'username' => 'admin',
            'profile_id' => 1
        ];

        $studentData = [
            'email' => 'student@gmail.com',
            'password' => '123456',
            'role' => UserRole::STUDENT,
            'status' => UserStatus::ACTIVE,
            'username' => 'student',
            'profile_id' => 2
        ];

        $teacherData = [
            'email' => 'teacher@gmail.com',
            'password' => '123456',
            'role' => UserRole::TEACHER,
            'status' => UserStatus::ACTIVE,
            'username' => 'teacher',
            'profile_id' => 3
        ];

        $otherTeacherData = User::create([
            'email' => 'otherTeacher@gmail.com',
            'password' => '123456',
            'role' => UserRole::TEACHER,
            'status' => UserStatus::ACTIVE,
            'username' => 'other_teacher',
            'profile_id' => 3
        ]);

        Profile::factory()->count(4)->create();

        $admin = User::create($adminData);
        $student = User::create($studentData);
        $teacher = User::create($teacherData);
        $otherTeacher = User::create($otherTeacherData);

        $schoolYear = SchoolYear::create([
            'name' => 'new school year',
            'start_at' => now(),
            'end_at' => now(),
        ]);

        $grade = Grade::create([
            'name' => 10,
        ]);

        $room = Room::create([
            'grade_id' => $grade->id,
            'name' => 'C1',
            'school_year_id' => $schoolYear->id,
            'homeroom_teacher_id' => $teacher->id,
        ]);

        $subject = Subject::create([
            'grade_id' => $grade->id,
            'name' => 'new subject',
            'number_lesson' => 150,
            'coefficient' => 2,
        ]);

        $teacherUser = Teacher::create([
            'user_id' => $teacher->id,
            'subject_id' => $subject->id,
        ]);

        $roomTeacher = RoomTeacher::create([
            'teacher_id' => $teacherUser->id,
            'room_id' => $room->id,
        ]);

        $studentUser = Student::create([
            'user_id' => $student->id,
            'school_year_id' => $schoolYear->id,
            'grade_id' => $grade->id,
            'room_id' => $room->id,
        ]);

        $examRescoreable = Exam::create([
            'content' => 'newExam',
            'room_teacher_id' => $roomTeacher->id,
            'type' => ExamType::FINAL_SEMESTER,
        ]);

        $examStudentRescoreable = ExamStudent::create([
            'exam_id' => $examRescoreable->id,
            'student_id' => $studentUser->id,
            'score' => random_int(0, 100),
            'review' => 'nana',
            'rescored_at' => '2023-10-22'
        ]);

        $exam = Exam::create([
            'content' => 'newExam',
            'room_teacher_id' => $roomTeacher->id,
            'type' => ExamType::FINAL_SEMESTER,
        ]);

        $examStudent = ExamStudent::create([
            'exam_id' => $exam->id,
            'student_id' => $studentUser->id,
            'score' => random_int(0, 100),
            'review' => 'nana',
        ]);

        $examRescoreableClose = Exam::create([
            'content' => 'newExam',
            'room_teacher_id' => $roomTeacher->id,
            'type' => ExamType::FINAL_SEMESTER,
        ]);

        $examStudentRescoreableClose = ExamStudent::create([
            'exam_id' => $examRescoreableClose->id,
            'student_id' => $studentUser->id,
            'score' => random_int(0, 100),
            'review' => 'nana',
            'rescored_at' => '2023-09-19'
        ]);

        $data = [
            'admin' => $admin,
            'student' => $student,
            'teacher' => $teacher,
            'otherTeacher' => $otherTeacher,
            'schoolYear' => $schoolYear,
            'grade' => $grade,
            'room' => $room,
            'subject' => $subject,
            'teacherUser' => $teacherUser,
            'studentUser' => $studentUser,
            'exam' => $exam,
            'examStudentRescoreable' => $examStudentRescoreable,
            'examStudent' => $examStudent,
            'examStudentRescoreableClose' => $examStudentRescoreableClose
        ];

        return $data;
    }
}