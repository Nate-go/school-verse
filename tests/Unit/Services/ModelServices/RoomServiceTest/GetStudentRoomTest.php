<?php

namespace Tests\Unit\Services\ModelServices\RoomServiceTest;

use App\Services\ModelServices\RoomService;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\BaseTest;

class GetStudentRoomTest extends BaseTest
{
    use RefreshDatabase;

    public function testStudentRoomExistAdminAccess()
    {
        $data = $this->setUpInitData();

        $admin = $data['admin'];
        $room = $data['room'];
        $student = $data['student'];
        $studentUser = $data['studentUser'];

        $roomService = app()->make(RoomService::class);
        $this->be($admin);
        $result = $roomService->getStudentRoom($student->id, $room->id);

        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('student.room.student-rooms-detail', $result->getName());
        $viewData = $result->getData();
        $this->assertEquals($studentUser->id, $viewData['studentId']);
    }

    public function testStudentRoomExistStudentAccess()
    {
        $data = $this->setUpInitData();

        $room = $data['room'];
        $student = $data['student'];
        $studentUser = $data['studentUser'];

        $roomService = app()->make(RoomService::class);
        $this->be($student);
        $result = $roomService->getStudentRoom($student->id, $room->id);

        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('student.room.student-rooms-detail', $result->getName());
        $viewData = $result->getData();
        $this->assertEquals($studentUser->id, $viewData['studentId']);
    }

    public function testStudentRoomNotExist()
    {
        $data = $this->setUpInitData();

        $student = $data['student'];

        $roomService = app()->make(RoomService::class);
        $this->be($student);
        $result = $roomService->getStudentRoom($student->id, 100);

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $result);

        $this->assertEquals(route('notFound'), $result->getTargetUrl());
    }

    public function testStudentRoomExistFalseUserAccess()
    {
        $data = $this->setUpInitData();

        $teacher = $data['teacher'];
        $room = $data['room'];
        $student = $data['student'];

        $roomService = app()->make(RoomService::class);
        $this->be($teacher);
        $result = $roomService->getStudentRoom($student->id, $room->id);

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $result);

        $this->assertEquals(route('notPermission'), $result->getTargetUrl());
    }

}