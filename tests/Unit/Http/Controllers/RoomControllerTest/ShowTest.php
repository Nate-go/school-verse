<?php

namespace Tests\Unit\Http\Controller\RoomControllerTest;

use Illuminate\Contracts\View\View;
use App\Http\Controllers\RoomController;
use Tests\Unit\BaseTest;

class ShowTest extends BaseTest
{
    public function testRoomExist()
    {
        $data = $this->setUpInitData();

        $room = $data['room'];
        $admin = $data['admin'];

        $this->be($admin);
        $roomController = app()->make(RoomController::class);
        $result = $roomController->show($room->id);

        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('admin.room.rooms-detail', $result->getName());
        $viewData = $result->getData();
        $this->assertEquals($room->id, $viewData['id']);
    }

    public function testRoomNotExist()
    {
        $data = $this->setUpInitData();
        $admin = $data['admin'];

        $this->be($admin);
        $roomController = app()->make(RoomController::class);
        $result = $roomController->show(0);

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $result);
        $this->assertEquals(route('notFound'), $result->getTargetUrl());
    }
}