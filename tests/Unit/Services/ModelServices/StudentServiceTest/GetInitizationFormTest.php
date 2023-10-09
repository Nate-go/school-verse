<?php

namespace Tests\Unit\Services\ModelServices\StudentServiceTest;

use App\Services\ModelServices\StudentService;
use Illuminate\Contracts\View\View;
use Tests\Unit\BaseTest;

class GetInitizationFormTest extends BaseTest
{
    public function testReturnView()
    {
        $studentService = app()->make(StudentService::class);
        $result = $studentService->getInitizationForm();

        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('admin.student.students-initialization', $result->getName());
    }
}
