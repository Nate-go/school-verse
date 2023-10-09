<?php

namespace Tests\Unit\Http\Controller\SchoolYearControllerTest;

use App\Services\TableService;
use Illuminate\Contracts\View\View;
use App\Constant\TableData;
use App\Http\Controllers\SchoolYearController;
use Tests\Unit\BaseTest;

class IndexTest extends BaseTest
{
    public function testReturnView()
    {
        $tableService = app()->make(TableService::class);
        $schoolYearController = app()->make(SchoolYearController::class);
        $result = $schoolYearController->index();

        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('admin.school-year.school-years', $result->getName());
        $viewData = $result->getData();
        $data = TableData::SCHOOLYEARS;
        $tableService->setTableForm($data);
        $this->assertEquals($data, $viewData['tableSource']);
    }
}