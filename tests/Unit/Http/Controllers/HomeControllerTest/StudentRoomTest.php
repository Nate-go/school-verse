<?php

namespace Tests\Unit\Http\Controller\HomeControllerTest;

use Illuminate\Contracts\View\View;
use App\Http\Controllers\HomeController;
use Tests\Unit\BaseTest;

class StudentRoomTest extends BaseTest
{
    public function testStudentRoomExistAdminAccess()
    {
        $data = $this->setUpInitData();

        $admin = $data['admin'];
        $room = $data['room'];
        $student = $data['student'];
        $studentUser = $data['studentUser'];

        $this->be($admin);
        $homeController = app()->make(HomeController::class);
        $result = $homeController->studentRoom($student->id, $room->id);
        
        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('student.room.student-rooms-detail', $result->getName());
        $viewData = $result->getData();
        $this->assertEquals($studentUser->id, $viewData['studentId']);
    }

    public function testStudentRoomExistStudentAccess()
    {
        $data = $this->setUpInitData();

        $room = $data['room'];
        $student = $data['student'];
        $studentUser = $data['studentUser'];

        $this->be($student);
        $homeController = app()->make(HomeController::class);
        $result = $homeController->studentRoom($student->id, $room->id);

        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('student.room.student-rooms-detail', $result->getName());
        $viewData = $result->getData();
        $this->assertEquals($studentUser->id, $viewData['studentId']);
    }

    public function testStudentRoomNotExist()
    {
        $data = $this->setUpInitData();

        $student = $data['student'];

        $this->be($student);
        $homeController = app()->make(HomeController::class);
        $result = $homeController->studentRoom($student->id, 100);

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $result);

        $this->assertEquals(route('notFound'), $result->getTargetUrl());
    }

    public function testStudentRoomExistFalseUserAccess()
    {
        $data = $this->setUpInitData();

        $teacher = $data['teacher'];
        $room = $data['room'];
        $student = $data['student'];

        $this->be($teacher);
        $homeController = app()->make(HomeController::class);
        $result = $homeController->studentRoom($student->id, $room->id);

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $result);

        $this->assertEquals(route('notPermission'), $result->getTargetUrl());
    }
}