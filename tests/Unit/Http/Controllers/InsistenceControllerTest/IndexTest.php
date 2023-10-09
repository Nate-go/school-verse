<?php

namespace Tests\Unit\Http\Controller\InsistenceControllerTest;

use App\Constant\TableData;
use App\Services\TableService;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\InsistenceController;
use Tests\Unit\BaseTest;

class IndexTest extends BaseTest
{
    public function testReturnViewForAdmin()
    {
        $data = $this->setUpInitData();
        $admin = $data['admin'];

        $this->be($admin);
        $tableService = app()->make(TableService::class);
        $insistenceController = app()->make(InsistenceController::class);
        $result = $insistenceController->index();

        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('admin.insistence.insistences', $result->getName());
        $viewData = $result->getData();
        $data = TableData::INSISTENCES;
        $tableService->setTableForm($data);
        $this->assertEquals($data, $viewData['tableSource']);
    }

    public function testReturnViewForUser()
    {
        $data = $this->setUpInitData();

        $user = $data['student'];

        $this->be($user);
        $tableService = app()->make(TableService::class);
        $insistenceController = app()->make(InsistenceController::class);
        $result = $insistenceController->index();

        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('user.insistences', $result->getName());
        $viewData = $result->getData();
        $data = TableData::USER_INSISTENCES;
        $tableService->setTableForm($data);
        $this->assertEquals($data, $viewData['tableSource']);
        $this->assertEquals($user->id, $viewData['userId']);
    }
}