<?php

namespace Tests\Unit\Services\ModelServices\StudentServiceTest;

use App\Services\ModelServices\StudentService;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\BaseTest;

class GetPageForStudentTest extends BaseTest
{
    use RefreshDatabase;

    public function testStudentExist()
    {
        $data = $this->setUpInitData();

        $student = $data['student'];

        $studentService = app()->make(StudentService::class);
        $result = $studentService->getPageForStudent($student->id);

        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('admin.student.students-detail', $result->getName());
        $viewData = $result->getData();
        $this->assertEquals($student->id, $viewData['id']);
    }

    public function testStudentNotExist()
    {
        $studentService = app()->make(StudentService::class);
        $result = $studentService->getPageForStudent(100);

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $result);
        $this->assertEquals(route('notFound'), $result->getTargetUrl());
    }
}