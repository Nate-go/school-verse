<?php

namespace Tests\Unit\Http\Controller\HomeControllerTest;

use Illuminate\Contracts\View\View;
use App\Http\Controllers\HomeController;
use App\Services\ModelServices\RoomService;
use Tests\Unit\BaseTest;

class IndexTest extends BaseTest
{
    public function testIndexAdmin()
    {
        $data = $this->setUpInitData();
        $admin = $data['admin'];

        $this->be($admin);

        $homeController = app()->make(HomeController::class);
        $result = $homeController->index();

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $result);

        $this->assertEquals(url('/') . '/insistences', $result->getTargetUrl());
    }

    public function testIndexTeacher()
    {
        $data = $this->setUpInitData();
        $teacher = $data['teacher'];

        $this->be($teacher);

        $homeController = app()->make(HomeController::class);
        $result = $homeController->index();

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $result);

        $this->assertEquals(url('/') . '/teachers', $result->getTargetUrl());
    }

    public function testIndexStudent()
    {
        $data = $this->setUpInitData();
        $student = $data['student'];

        $this->be($student);

        $homeController = app()->make(HomeController::class);
        $roomService = app()->make(RoomService::class);
        $result = $homeController->index();

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $result);
        $url = $roomService->getUrlForStudent();
        $this->assertEquals(url('/') . $url, $result->getTargetUrl());
    }
}