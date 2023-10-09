<?php

namespace Tests\Unit\Http\Controller\StudentControllerTest;

use Illuminate\Contracts\View\View;
use App\Http\Controllers\StudentController;
use Tests\Unit\BaseTest;

class CreateTest extends BaseTest
{
    public function testReturnView()
    {
        $studentController = app()->make(StudentController::class);
        $result = $studentController->create();

        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('admin.student.students-initialization', $result->getName());
    }
}