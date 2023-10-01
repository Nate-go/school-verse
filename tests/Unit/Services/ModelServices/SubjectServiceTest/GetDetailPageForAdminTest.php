<?php

namespace Tests\Unit\Services\ModelServices\SubjectServiceTest;

use App\Services\ModelServices\StudentService;
use App\Services\ModelServices\SubjectService;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\BaseTest;

class GetDetailPageForAdminTest extends BaseTest
{
    use RefreshDatabase;

    public function testSubjectExist()
    {
        $data = $this->setUpInitData();

        $subject = $data['subject'];

        $subjectService = app()->make(SubjectService::class);
        $result = $subjectService->getDetailPageForAdmin($subject->id);

        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('admin.subject.subjects-detail', $result->getName());
        $viewData = $result->getData();
        $this->assertEquals($subject->id, $viewData['id']);
    }

    public function testStudentNotExist()
    {
        $subjectService = app()->make(SubjectService::class);
        $result = $subjectService->getDetailPageForAdmin(100);

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $result);
        $this->assertEquals(route('notFound'), $result->getTargetUrl());
    }
}