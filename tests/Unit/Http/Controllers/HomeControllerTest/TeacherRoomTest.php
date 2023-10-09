<?php

namespace Tests\Unit\Http\Controller\HomeControllerTest;

use Illuminate\Contracts\View\View;
use App\Http\Controllers\HomeController;
use Tests\Unit\BaseTest;

class GetTeacherRoomTest extends BaseTest
{
    public function testTeachertRoomExistAdminAccess()
    {
        $data = $this->setUpInitData();

        $admin = $data['admin'];
        $roomTeacher = $data['roomTeacher'];

        $this->be($admin);
        $homeController = app()->make(HomeController::class);
        $result = $homeController->teacherRoom($roomTeacher->id);

        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('teacher.room.teacher-rooms-detail', $result->getName());
        $viewData = $result->getData();
        $this->assertEquals($roomTeacher->id, $viewData['roomTeacherId']);
    }

    public function testTeacherRoomExistTrueTeacherAccess()
    {
        $data = $this->setUpInitData();

        $teacher = $data['teacher'];
        $roomTeacher = $data['roomTeacher'];

        $this->be($teacher);
        $homeController = app()->make(HomeController::class);
        $result = $homeController->teacherRoom($roomTeacher->id);

        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('teacher.room.teacher-rooms-detail', $result->getName());
        $viewData = $result->getData();
        $this->assertEquals($roomTeacher->id, $viewData['roomTeacherId']);
    }

    public function testTeacherRoomExistFalseUserAccess()
    {
        $data = $this->setUpInitData();

        $otherTeacher = $data['otherTeacher'];
        $roomTeacher = $data['roomTeacher'];

        $this->be($otherTeacher);
        $homeController = app()->make(HomeController::class);
        $result = $homeController->teacherRoom($roomTeacher->id);

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $result);

        $this->assertEquals(route('notPermission'), $result->getTargetUrl());
    }

    public function testTeacherRoomNotExist()
    {
        $data = $this->setUpInitData();

        $admin = $data['admin'];

        $this->be($admin);
        $homeController = app()->make(HomeController::class);
        $result = $homeController->teacherRoom(100);

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $result);

        $this->assertEquals(route('notFound'), $result->getTargetUrl());
    }
}