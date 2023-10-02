<?php

namespace Tests\Unit\Services\ModelServices\RoomServiceTest;

use App\Services\ModelServices\RoomService;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\BaseTest;

class GetTeacherRoomTest extends BaseTest
{
    use RefreshDatabase;

    public function testTeachertRoomExistAdminAccess()
    {
        $data = $this->setUpInitData();

        $admin = $data['admin'];
        $roomTeacher = $data['roomTeacher'];

        $roomService = app()->make(RoomService::class);
        $this->be($admin);
        $result = $roomService->getTeacherRoom($roomTeacher->id);

        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('teacher.room.teacher-rooms-detail', $result->getName());
        $viewData = $result->getData();
        $this->assertEquals($roomTeacher->id, $viewData['roomTeacherId']);
    }

    public function testTeacherRoomExistTrueTeacherAccess()
    {
        $data = $this->setUpInitData();

        $teacher = $data['teacher'];
        $roomTeacher = $data['roomTeacher'];

        $roomService = app()->make(RoomService::class);
        $this->be($teacher);
        $result = $roomService->getTeacherRoom($roomTeacher->id);

        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('teacher.room.teacher-rooms-detail', $result->getName());
        $viewData = $result->getData();
        $this->assertEquals($roomTeacher->id, $viewData['roomTeacherId']);
    }

    public function testTeacherRoomExistFalseUserAccess()
    {
        $data = $this->setUpInitData();

        $otherTeacher = $data['otherTeacher'];
        $roomTeacher = $data['roomTeacher'];

        $roomService = app()->make(RoomService::class);
        $this->be($otherTeacher);
        $result = $roomService->getTeacherRoom($roomTeacher->id);

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $result);

        $this->assertEquals(route('notPermission'), $result->getTargetUrl());
    }

    public function testTeacherRoomNotExist()
    {
        $data = $this->setUpInitData();

        $admin = $data['admin'];

        $roomService = app()->make(RoomService::class);
        $this->be($admin);
        $result = $roomService->getTeacherRoom(100);

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $result);

        $this->assertEquals(route('notFound'), $result->getTargetUrl());
    }
}
