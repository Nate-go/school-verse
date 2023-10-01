<?php

namespace Tests\Unit\Services\ModelServices\InsistenceServiceTest;

use App\Constant\TableData;
use App\Services\ModelServices\InsistenceService;
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

        $insistenceService = app()->make(InsistenceService::class);
        $tableService = app()->make(TableService::class);
        $result = $insistenceService->getPageForAdmin();

        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('admin.insistence.insistences', $result->getName());
        $viewData = $result->getData();
        $data = TableData::INSISTENCES;
        $tableService->setTableForm($data);
        $this->assertEquals($data, $viewData['tableSource']);
    }
}