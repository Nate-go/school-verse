<?php

namespace Tests\Unit\Services\ModelServices\SchoolYearServiceTest;

use App\Constant\TableData;
use App\Services\ModelServices\SchoolYearService;
use App\Services\TableService;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\BaseTest;

class GetPageForAdminTest extends BaseTest
{
    use RefreshDatabase;

    public function testReturnView()
    {
        $schoolYearService = app()->make(SchoolYearService::class);
        $tableService = app()->make(TableService::class);
        $result = $schoolYearService->getPageForAdmin();

        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('admin.school-year.school-years', $result->getName());
        $viewData = $result->getData();
        $data = TableData::SCHOOLYEARS;
        $tableService->setTableForm($data);
        $this->assertEquals($data, $viewData['tableSource']);
    }
}
