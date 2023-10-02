<?php

namespace Tests\Unit\Services\ModelServices\InsistenceServiceTest;

use App\Constant\TableData;
use App\Services\ModelServices\InsistenceService;
use App\Services\TableService;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\BaseTest;

class GetPageForUserTest extends BaseTest
{
    use RefreshDatabase;

    public function testReturnView()
    {
        $data = $this->setUpInitData();

        $user = $data['student'];

        $insistenceService = app()->make(InsistenceService::class);
        $tableService = app()->make(TableService::class);
        $result = $insistenceService->getPageForUser($user->id);

        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('user.insistences', $result->getName());
        $viewData = $result->getData();
        $data = TableData::USER_INSISTENCES;
        $tableService->setTableForm($data);
        $this->assertEquals($data, $viewData['tableSource']);
        $this->assertEquals($user->id, $viewData['userId']);
    }
}
