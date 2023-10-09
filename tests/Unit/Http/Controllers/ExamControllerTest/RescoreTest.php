<?php

namespace Tests\Unit\Http\Controller\ExamControllerTest;

use Illuminate\Contracts\View\View;
use App\Http\Controllers\ExamController;
use Tests\Unit\BaseTest;

class RescoreTest extends BaseTest
{
    public function testAdminCanAccessPage()
    {
        $data = $this->setUpInitData();

        $examController = app()->make(ExamController::class);
        $this->be($data['admin']);
        $result = $examController->rescore($data['examStudentRescoreable']->id);

        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('teacher.exam.rescore', $result->getName());

        $viewData = $result->getData();

        $this->assertEquals($data['examStudentRescoreable']->id, $viewData['examStudentId']);
    }

    public function testTrueTeacherCanAccessPage()
    {
        $data = $this->setUpInitData();

        $examController = app()->make(ExamController::class);
        $this->be($data['teacher']);
        $result = $examController->rescore($data['examStudentRescoreable']->id);

        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('teacher.exam.rescore', $result->getName());

        $viewData = $result->getData();

        $this->assertEquals($data['examStudentRescoreable']->id, $viewData['examStudentId']);
    }

    public function testFalseTeacherCanNotAccessPage()
    {
        $data = $this->setUpInitData();

        $examController = app()->make(ExamController::class);
        $this->be($data['otherTeacher']);
        $result = $examController->rescore($data['examStudentRescoreable']->id);

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $result);

        $this->assertEquals(route('notFound'), $result->getTargetUrl());
    }

    public function testStudentCanNotAccessPage()
    {
        $data = $this->setUpInitData();

        $examController = app()->make(ExamController::class);
        $this->be($data['student']);
        $result = $examController->rescore($data['examStudentRescoreable']->id);

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $result);

        $this->assertEquals(route('notFound'), $result->getTargetUrl());
    }

    public function testRescoreableNotOpenYetCanNotAccessPage()
    {
        $data = $this->setUpInitData();

        $examController = app()->make(ExamController::class);
        $this->be($data['admin']);
        $result = $examController->rescore($data['examStudent']->id);

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $result);

        $this->assertEquals(route('notFound'), $result->getTargetUrl());
    }

    public function testRescoreableIsClosedCanNotAccessPage()
    {
        $data = $this->setUpInitData();

        $examController = app()->make(ExamController::class);
        $this->be($data['admin']);
        $result = $examController->rescore($data['examStudentRescoreableClose']->id);

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $result);

        $this->assertEquals(route('notFound'), $result->getTargetUrl());
    }
}