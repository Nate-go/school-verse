<?php

namespace Tests\Unit\Http\Controller\GradeControllerTest;

use App\Constant\TableData;
use App\Services\TableService;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\GradeController;
use Tests\Unit\BaseTest;

class IndexTest extends BaseTest
{
    public function testReturnView()
    {
        $data = $this->setUpInitData();

        $tableService = app()->make(TableService::class);
        $gradeController = app()->make(GradeController::class);
        $result = $gradeController->index();

        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('admin.grade.grades', $result->getName());
        $viewData = $result->getData();
        $data = TableData::GRADES;
        $tableService->setTableForm($data);
        $this->assertEquals($data, $viewData['tableSource']);
    }
}