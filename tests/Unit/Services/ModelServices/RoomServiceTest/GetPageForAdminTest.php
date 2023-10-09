<?php

namespace Tests\Unit\Services\ModelServices\RoomServiceTest;

use App\Constant\TableData;
use App\Services\ModelServices\RoomService;
use App\Services\TableService;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\BaseTest;

class GetPageForAdminTest extends BaseTest
{
    public function testReturnView()
    {
        $roomService = app()->make(RoomService::class);
        $tableService = app()->make(TableService::class);
        $result = $roomService->getPageForAdmin();

        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('admin.room.rooms', $result->getName());
        $viewData = $result->getData();
        $data = TableData::ROOMS;
        $tableService->setTableForm($data);
        $this->assertEquals($data, $viewData['tableSource']);
    }
}
