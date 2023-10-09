<?php

namespace Tests\Unit\Http\Controller\HomeControllerTest;

use Illuminate\Contracts\View\View;
use App\Http\Controllers\HomeController;
use Tests\Unit\BaseTest;

class HomeroomTest extends BaseTest
{
    public function testRoomExistAdminAccess()
    {
        $data = $this->setUpInitData();

        $admin = $data['admin'];
        $room = $data['room'];

        $this->be($admin);
        $homeController = app()->make(HomeController::class);
        $result = $homeController->homeroom($room->id);

        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('teacher.room.homerooms-detail', $result->getName());
        $viewData = $result->getData();
        $this->assertEquals($room->id, $viewData['id']);
    }

    public function testRoomExistTreuTeacherAccess()
    {
        $data = $this->setUpInitData();

        $teacher = $data['teacher'];
        $room = $data['room'];

        $this->be($teacher);
        $homeController = app()->make(HomeController::class);
        $result = $homeController->homeroom($room->id);

        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('teacher.room.homerooms-detail', $result->getName());
        $viewData = $result->getData();
        $this->assertEquals($room->id, $viewData['id']);
    }

    public function testRoomExistFalseTeacherAccess()
    {
        $data = $this->setUpInitData();

        $otherTeacher = $data['otherTeacher'];
        $room = $data['room'];

        $this->be($otherTeacher);
        $homeController = app()->make(HomeController::class);
        $result = $homeController->homeroom($room->id);

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $result);

        $this->assertEquals(route('notPermission'), $result->getTargetUrl());
    }

    public function testRoomNotExist()
    {
        $homeController = app()->make(HomeController::class);
        $result = $homeController->homeroom(0);

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $result);
        $this->assertEquals(route('notFound'), $result->getTargetUrl());
    }
}