<?php

namespace Tests\Unit;

use App\Constant\ExamType;
use App\Constant\InsistenceTypes;
use App\Constant\UserRole;
use App\Constant\UserStatus;
use App\Models\Exam;
use App\Models\ExamStudent;
use App\Models\Grade;
use App\Models\Insistence;
use App\Models\Profile;
use App\Models\Room;
use App\Models\RoomTeacher;
use App\Models\SchoolYear;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BaseTest extends TestCase
{
    use RefreshDatabase;

    public function setUpInitData()
    {
        $data = [];

        $adminData = [
            'email' => 'admin@gmail.com',
            'password' => '123456',
            'role' => UserRole::ADMIN,
            'status' => UserStatus::ACTIVE,
            'username' => 'admin',
            'profile_id' => 1,
        ];

        $studentData = [
            'email' => 'student@gmail.com',
            'password' => '123456',
            'role' => UserRole::STUDENT,
            'status' => UserStatus::ACTIVE,
            'username' => 'student',
            'profile_id' => 2,
        ];

        $teacherData = [
            'email' => 'teacher@gmail.com',
            'password' => '123456',
            'role' => UserRole::TEACHER,
            'status' => UserStatus::ACTIVE,
            'username' => 'teacher',
            'profile_id' => 3,
        ];

        $otherTeacherData = [
            'email' => 'otherTeacher@gmail.com',
            'password' => '123456',
            'role' => UserRole::TEACHER,
            'status' => UserStatus::ACTIVE,
            'username' => 'other_teacher',
            'profile_id' => 4,
        ];

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
            'rescored_at' => '2023-10-22',
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
            'rescored_at' => '2023-09-19',
        ]);

        $insistence = Insistence::create([
            'user_id' => $student->id,
            'content' => 'new content',
            'feedback' => 'new feedback',
            'status' => \App\Constant\Insistence::PENDING,
            'type' => InsistenceTypes::NORMAL,
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
            'examStudentRescoreableClose' => $examStudentRescoreableClose,
            'insistence' => $insistence,
            'roomTeacher' => $roomTeacher,
        ];

        return $data;
    }
}
