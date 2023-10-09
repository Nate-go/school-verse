<?php

namespace Tests\Unit\Http\Controller\StudentControllerTest;

use App\Services\TableService;
use Illuminate\Contracts\View\View;
use App\Constant\TableData;
use App\Http\Controllers\StudentController;
use Tests\Unit\BaseTest;

class IndexTest extends BaseTest
{
    public function testReturnView()
    {
        $studentController = app()->make(StudentController::class);
        $tableService = app()->make(TableService::class);
        $result = $studentController->index();

        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('admin.student.students', $result->getName());
        $viewData = $result->getData();
        $data = TableData::STUDENTS;
        $tableService->setTableForm($data);
        $this->assertEquals($data, $viewData['tableSource']);
    }
}