<?php

namespace Tests\Unit\Services\ModelServices\RoomServiceTest;

use App\Services\ModelServices\RoomService;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\BaseTest;

class GetDetailPageForAdminTest extends BaseTest
{
    use RefreshDatabase;

    public function testRoomExist()
    {
        $data = $this->setUpInitData();

        $room = $data['room'];

        $roomService = app()->make(RoomService::class);
        $result = $roomService->getDetailPageForAdmin($room->id);

        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('admin.room.rooms-detail', $result->getName());
        $viewData = $result->getData();
        $this->assertEquals($room->id, $viewData['id']);
    }

    public function testRoomNotExist()
    {
        $roomService = app()->make(RoomService::class);
        $result = $roomService->getDetailPageForAdmin(0);

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $result);
        $this->assertEquals(route('notFound'), $result->getTargetUrl());
    }
}
