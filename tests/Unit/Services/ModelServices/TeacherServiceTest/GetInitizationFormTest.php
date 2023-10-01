<?php

namespace Tests\Unit\Services\ModelServices\TeacherServiceTest;

use App\Services\ModelServices\StudentService;
use App\Services\ModelServices\TeacherService;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\BaseTest;

class GetInitizationFormTest extends BaseTest
{
    use RefreshDatabase;

    public function testReturnView()
    {
        $teacherService = app()->make(TeacherService::class);
        $result = $teacherService->getInitizationForm();

        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('admin.teacher.teachers-initialization', $result->getName());
    }
}