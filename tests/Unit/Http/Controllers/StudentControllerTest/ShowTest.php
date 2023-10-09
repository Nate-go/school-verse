<?php

namespace Tests\Unit\Http\Controller\SchoolYearControllerTest;

use App\Http\Controllers\SchoolYearController;
use Illuminate\Contracts\View\View;
use Tests\Unit\BaseTest;

class ShowTest extends BaseTest
{
    public function testSchoolYearExist()
    {
        $data = $this->setUpInitData();

        $schoolYear = $data['schoolYear'];

        $schoolYearController = app()->make(SchoolYearController::class);
        $result = $schoolYearController->show($schoolYear->id);

        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('admin.school-year.school-years-detail', $result->getName());
        $viewData = $result->getData();
        $this->assertEquals($schoolYear->id, $viewData['id']);
    }

    public function testSchoolYearNotExist()
    {
        $schoolYearController = app()->make(SchoolYearController::class);
        $result = $schoolYearController->show(100);

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $result);
        $this->assertEquals(route('notFound'), $result->getTargetUrl());
    }
}