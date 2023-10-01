<?php

namespace Tests\Unit\Services\ModelServices\RoomServiceTest;

use App\Services\ModelServices\RoomService;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\BaseTest;

class GetInitizationFormTest extends BaseTest
{
    use RefreshDatabase;

    public function testReturnView()
    {
        $roomService = app()->make(RoomService::class);
        $result = $roomService->getInitizationForm();

        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('admin.room.rooms-initialization', $result->getName());
    }
}