<?php

namespace Tests\Unit\Services\ModelServices\TeacherServiceTest;

use App\Services\ModelServices\TeacherService;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\BaseTest;

class GetPageForTeacherTest extends BaseTest
{
    use RefreshDatabase;

    public function testTeacherExist()
    {
        $data = $this->setUpInitData();

        $teacher = $data['teacher'];

        $teacherService = app()->make(TeacherService::class);
        $this->be($teacher);
        $result = $teacherService->getPageForTeacher($teacher->id);

        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('admin.teacher.teachers-detail', $result->getName());
        $viewData = $result->getData();
        $this->assertEquals($teacher->id, $viewData['id']);
    }

    public function testTeacherExistFalseAccess()
    {
        $data = $this->setUpInitData();

        $teacher = $data['teacher'];
        $otherTeacher = $data['otherTeacher'];

        $teacherService = app()->make(TeacherService::class);
        $this->be($otherTeacher);
        $result = $teacherService->getPageForTeacher($teacher->id);

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $result);
        $this->assertEquals(route('notPermission'), $result->getTargetUrl());
    }

    public function testStudentNotExist()
    {
        $teacherService = app()->make(TeacherService::class);
        $result = $teacherService->getPageForTeacher(100);

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $result);
        $this->assertEquals(route('notFound'), $result->getTargetUrl());
    }
}
