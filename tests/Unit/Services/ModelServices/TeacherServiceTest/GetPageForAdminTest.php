<?php

namespace Tests\Unit\Services\ModelServices\TeacherServiceTest;

use App\Constant\TableData;
use App\Services\ModelServices\StudentService;
use App\Services\ModelServices\TeacherService;
use App\Services\TableService;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\BaseTest;

class GetPageForAdminTest extends BaseTest
{
    use RefreshDatabase;

    public function testReturnView()
    {
        $teacherService = app()->make(TeacherService::class);
        $tableService = app()->make(TableService::class);
        $result = $teacherService->getPageForAdmin();

        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('admin.teacher.teachers', $result->getName());
        $viewData = $result->getData();
        $data = TableData::TEACHERS;
        $tableService->setTableForm($data);
        $this->assertEquals($data, $viewData['tableSource']);
    }
}