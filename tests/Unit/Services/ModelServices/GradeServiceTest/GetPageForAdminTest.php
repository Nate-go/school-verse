<?php

namespace Tests\Unit\Services\ModelServices\GradeServiceTest;

use App\Constant\TableData;
use App\Services\ModelServices\GradeService;
use App\Services\TableService;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\BaseTest;

class GetPageForAdminTest extends BaseTest
{
    use RefreshDatabase;

    public function testReturnView()
    {
        $data = $this->setUpInitData();

        $gradeService = app()->make(GradeService::class);
        $tableService = app()->make(TableService::class);
        $result = $gradeService->getPageForAdmin();

        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('admin.grade.grades', $result->getName());
        $viewData = $result->getData();
        $data = TableData::GRADES;
        $tableService->setTableForm($data);
        $this->assertEquals($data, $viewData['tableSource']);
    }
}
