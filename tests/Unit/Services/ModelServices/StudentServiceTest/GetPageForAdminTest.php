<?php

namespace Tests\Unit\Services\ModelServices\StudentServiceTest;

use App\Constant\TableData;
use App\Services\ModelServices\StudentService;
use App\Services\TableService;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\BaseTest;

class GetPageForAdminTest extends BaseTest
{
    use RefreshDatabase;

    public function testReturnView()
    {
        $studentService = app()->make(StudentService::class);
        $tableService = app()->make(TableService::class);
        $result = $studentService->getPageForAdmin();

        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('admin.student.students', $result->getName());
        $viewData = $result->getData();
        $data = TableData::STUDENTS;
        $tableService->setTableForm($data);
        $this->assertEquals($data, $viewData['tableSource']);
    }
}