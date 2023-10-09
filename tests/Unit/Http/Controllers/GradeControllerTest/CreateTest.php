<?php

namespace Tests\Unit\Http\Controller\GradeControllerTest;

use Illuminate\Contracts\View\View;
use App\Http\Controllers\GradeController;
use Tests\Unit\BaseTest;

class CreateTest extends BaseTest
{
    public function testReturnView()
    {
        $gradeController = app()->make(GradeController::class);
        $result = $gradeController->create();

        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('admin.grade.grades-initialization', $result->getName());
    }
}