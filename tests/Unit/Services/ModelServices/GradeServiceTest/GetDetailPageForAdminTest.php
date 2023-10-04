<?php

namespace Tests\Unit\Services\ModelServices\GradeServiceTest;

use App\Services\ModelServices\GradeService;
use Illuminate\Contracts\View\View;
use Tests\Unit\BaseTest;

class GetDetailPageForAdminTest extends BaseTest
{
    public function testGetExistGrade()
    {
        $data = $this->setUpInitData();

        $grade = $data['grade'];

        $gradeService = app()->make(GradeService::class);
        $result = $gradeService->getDetailPageForAdmin($grade->id);

        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('admin.grade.grades-detail', $result->getName());

        $viewData = $result->getData();

        $this->assertEquals($grade->id, $viewData['id']);
    }

    public function testGetNotExistGrade()
    {
        $gradeService = app()->make(GradeService::class);
        $result = $gradeService->getDetailPageForAdmin(0);

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $result);

        $this->assertEquals(route('notFound'), $result->getTargetUrl());
    }
}
