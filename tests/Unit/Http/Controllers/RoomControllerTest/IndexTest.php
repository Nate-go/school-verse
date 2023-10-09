<?php

namespace Tests\Unit\Http\Controller\RoomControllerTest;

use App\Constant\TableData;
use App\Services\TableService;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\RoomController;
use Tests\Unit\BaseTest;

class IndexTest extends BaseTest
{
    public function testReturnView()
    {
        $data = $this->setUpInitData();
        $admin = $data['admin'];

        $this->be($admin);
        $roomController = app()->make(RoomController::class);
        $result = $roomController->index();
        $tableService = app()->make(TableService::class);

        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('admin.room.rooms', $result->getName());
        $viewData = $result->getData();
        $data = TableData::ROOMS;
        $tableService->setTableForm($data);
        $this->assertEquals($data, $viewData['tableSource']);
    }
}