<?php

namespace Tests\Unit\Http\Controller\RoomControllerTest;

use Illuminate\Contracts\View\View;
use App\Http\Controllers\RoomController;
use Tests\Unit\BaseTest;

class CreateTest extends BaseTest
{
    public function testReturnView()
    {
        $data = $this->setUpInitData();
        $admin = $data['admin'];

        $this->be($admin);
        $roomController = app()->make(RoomController::class);
        $result = $roomController->create();

        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('admin.room.rooms-initialization', $result->getName());
    }
}