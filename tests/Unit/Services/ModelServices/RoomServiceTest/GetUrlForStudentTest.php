<?php

namespace Tests\Unit\Services\ModelServices\RoomServiceTest;

use App\Services\ModelServices\RoomService;
use App\Services\ModelServices\SchoolYearService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery\MockInterface;
use Tests\Unit\BaseTest;

class GetUrlForStudentTest extends BaseTest
{
    public function testStudentRoomExist()
    {
        $data = $this->setUpInitData();

        $student = $data['student'];
        $room = $data['room'];
        $schoolYear = $data['schoolYear'];

        $mock = $this->mock(SchoolYearService::class, function (MockInterface $mock) use ($schoolYear) {
            $mock->shouldReceive('getCurrentSchoolYear')->andReturn($schoolYear->id);
        });

        $roomService = app()->make(RoomService::class);
        $this->be($student);
        $result = $roomService->getUrlForStudent();

        $url = '/students/'.str($student->id).'/rooms/'.str($room->id);
        $this->assertEquals($url, $result);
    }

    public function testStudentRoomNotExist()
    {
        $data = $this->setUpInitData();

        $student = $data['student'];

        $mock = $this->mock(SchoolYearService::class, function (MockInterface $mock) {
            $mock->shouldReceive('getCurrentSchoolYear')->andReturn(100);
        });

        $roomService = app()->make(RoomService::class);
        $this->be($student);
        $result = $roomService->getUrlForStudent();

        $url = '/students';
        $this->assertEquals($url, $result);
    }
}
