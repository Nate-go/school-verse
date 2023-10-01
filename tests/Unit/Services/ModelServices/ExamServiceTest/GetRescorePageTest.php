<?php

namespace Tests\Unit\Services\ModelServices\ExamServiceTest;

use App\Services\ModelServices\ExamService;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\BaseTest;

class GetRescorePageTest extends BaseTest
{
    use RefreshDatabase;

    public function testAdminCanAccessPage()
    {
        $data = $this->setUpInitData();

        $examService = app()->make(ExamService::class);
        $this->be($data['admin']);
        $result = $examService->getRescorePage($data['examStudentRescoreable']->id);

        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('teacher.exam.rescore', $result->getName());

        $viewData = $result->getData();

        $this->assertEquals($data['examStudentRescoreable']->id, $viewData['examStudentId']);
    }

    public function testTrueTeacherCanAccessPage()
    {
        $data = $this->setUpInitData();

        $examService = app()->make(ExamService::class);
        $this->be($data['teacher']);
        $result = $examService->getRescorePage($data['examStudentRescoreable']->id);

        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('teacher.exam.rescore', $result->getName());

        $viewData = $result->getData();

        $this->assertEquals($data['examStudentRescoreable']->id, $viewData['examStudentId']);
    }

    public function testFalseTeacherCanNotAccessPage()
    {
        $data = $this->setUpInitData();

        $examService = app()->make(ExamService::class);
        $this->be($data['otherTeacher']);
        $result = $examService->getRescorePage($data['examStudentRescoreable']->id);

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $result);

        $this->assertEquals(route('notFound'), $result->getTargetUrl());
    }

    public function testStudentCanNotAccessPage()
    {
        $data = $this->setUpInitData();

        $examService = app()->make(ExamService::class);
        $this->be($data['student']);
        $result = $examService->getRescorePage($data['examStudentRescoreable']->id);

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $result);

        $this->assertEquals(route('notFound'), $result->getTargetUrl());
    }

    public function testRescoreableNotOpenYetCanNotAccessPage()
    {
        $data = $this->setUpInitData();

        $examService = app()->make(ExamService::class);
        $this->be($data['admin']);
        $result = $examService->getRescorePage($data['examStudent']->id);

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $result);

        $this->assertEquals(route('notFound'), $result->getTargetUrl());
    }

    public function testRescoreableIsClosedCanNotAccessPage()
    {
        $data = $this->setUpInitData();

        $examService = app()->make(ExamService::class);
        $this->be($data['admin']);
        $result = $examService->getRescorePage($data['examStudentRescoreableClose']->id);

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $result);

        $this->assertEquals(route('notFound'), $result->getTargetUrl());
    }
}