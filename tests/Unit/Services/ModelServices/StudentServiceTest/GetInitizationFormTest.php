<?php

namespace Tests\Unit\Services\ModelServices\StudentServiceTest;

use App\Services\ModelServices\SchoolYearService;
use App\Services\ModelServices\StudentService;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\BaseTest;

class GetInitizationFormTest extends BaseTest
{
    use RefreshDatabase;

    public function testReturnView()
    {
        $studentService = app()->make(StudentService::class);
        $result = $studentService->getInitizationForm();

        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('admin.student.students-initialization', $result->getName());
    }
}