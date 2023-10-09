<?php

namespace Tests\Unit\Services\ModelServices\SchoolYearServiceTest;

use App\Services\ModelServices\RoomService;
use App\Services\ModelServices\SchoolYearService;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\BaseTest;

class GetDetailPageForAdminTest extends BaseTest
{
    public function testSchoolYearExist()
    {
        $data = $this->setUpInitData();

        $schoolYear = $data['schoolYear'];

        $schoolYearService = app()->make(SchoolYearService::class);
        $result = $schoolYearService->getDetailPageForAdmin($schoolYear->id);

        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('admin.school-year.school-years-detail', $result->getName());
        $viewData = $result->getData();
        $this->assertEquals($schoolYear->id, $viewData['id']);
    }

    public function testSchoolYearNotExist()
    {
        $schoolYearService = app()->make(SchoolYearService::class);
        $result = $schoolYearService->getDetailPageForAdmin(100);

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $result);
        $this->assertEquals(route('notFound'), $result->getTargetUrl());
    }
}
