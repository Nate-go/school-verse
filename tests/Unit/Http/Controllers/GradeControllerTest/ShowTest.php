<?php

namespace Tests\Unit\Http\Controller\GradeControllerTest;

use Illuminate\Contracts\View\View;
use App\Http\Controllers\GradeController;
use Tests\Unit\BaseTest;

class ShowTest extends BaseTest
{
    public function testGetExistGrade()
    {
        $data = $this->setUpInitData();

        $grade = $data['grade'];

        $gradeController = app()->make(GradeController::class);
        $result = $gradeController->show($grade->id);

        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('admin.grade.grades-detail', $result->getName());

        $viewData = $result->getData();

        $this->assertEquals($grade->id, $viewData['id']);
    }

    public function testGetNotExistGrade()
    {
        $gradeController = app()->make(GradeController::class);
        $result = $gradeController->show(0);

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $result);

        $this->assertEquals(route('notFound'), $result->getTargetUrl());
    }
}