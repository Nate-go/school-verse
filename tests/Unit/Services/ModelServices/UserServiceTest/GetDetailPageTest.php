<?php

namespace Tests\Unit\Services\ModelServices\UserServiceTest;

use App\Services\ModelServices\TeacherService;
use App\Services\ModelServices\UserService;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\BaseTest;

class GetDetailPageTest extends BaseTest
{
    use RefreshDatabase;

    public function testUserExist()
    {
        $data = $this->setUpInitData();

        $teacher = $data['teacher'];

        $userService = app()->make(UserService::class);
        $result = $userService->getDetailPage($teacher->id);

        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('user.users-detail', $result->getName());
        $viewData = $result->getData();
        $this->assertEquals($teacher->id, $viewData['id']);
    }

    public function testStudentNotExist()
    {
        $userService = app()->make(UserService::class);
        $result = $userService->getDetailPage(100);

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $result);
        $this->assertEquals(route('notFound'), $result->getTargetUrl());
    }
}