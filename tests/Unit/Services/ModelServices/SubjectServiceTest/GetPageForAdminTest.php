<?php

namespace Tests\Unit\Services\ModelServices\SubjectServiceTest;

use App\Constant\TableData;
use App\Services\ModelServices\StudentService;
use App\Services\ModelServices\SubjectService;
use App\Services\TableService;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\BaseTest;

class GetPageForAdminTest extends BaseTest
{
    use RefreshDatabase;

    public function testReturnView()
    {
        $subjectService = app()->make(SubjectService::class);
        $tableService = app()->make(TableService::class);
        $result = $subjectService->getPageForAdmin();

        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('admin.subject.subjects', $result->getName());
        $viewData = $result->getData();
        $data = TableData::SUBJECTS;
        $tableService->setTableForm($data);
        $this->assertEquals($data, $viewData['tableSource']);
    }
}