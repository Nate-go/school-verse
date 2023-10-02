<?php

namespace Tests\Unit\Services\ModelServices\RoomServiceTest;

use App\Services\ModelServices\RoomService;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\BaseTest;

class GetHomeroomPageTest extends BaseTest
{
    use RefreshDatabase;

    public function testRoomExistAdminAccess()
    {
        $data = $this->setUpInitData();

        $admin = $data['admin'];
        $room = $data['room'];

        $roomService = app()->make(RoomService::class);
        $this->be($admin);
        $result = $roomService->getHomeroomPage($room->id);

        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('teacher.room.homerooms-detail', $result->getName());
        $viewData = $result->getData();
        $this->assertEquals($room->id, $viewData['id']);
    }

    public function testRoomExistTreuTeacherAccess()
    {
        $data = $this->setUpInitData();

        $teacher = $data['teacher'];
        $room = $data['room'];

        $roomService = app()->make(RoomService::class);
        $this->be($teacher);
        $result = $roomService->getHomeroomPage($room->id);

        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('teacher.room.homerooms-detail', $result->getName());
        $viewData = $result->getData();
        $this->assertEquals($room->id, $viewData['id']);
    }

    public function testRoomExistFalseTeacherAccess()
    {
        $data = $this->setUpInitData();

        $otherTeacher = $data['otherTeacher'];
        $room = $data['room'];

        $roomService = app()->make(RoomService::class);
        $this->be($otherTeacher);
        $result = $roomService->getHomeroomPage($room->id);

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $result);

        $this->assertEquals(route('notPermission'), $result->getTargetUrl());
    }

    public function testRoomNotExist()
    {
        $roomService = app()->make(RoomService::class);
        $result = $roomService->getHomeroomPage(0);

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $result);
        $this->assertEquals(route('notFound'), $result->getTargetUrl());
    }
}
