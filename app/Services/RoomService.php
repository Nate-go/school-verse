<?php

namespace App\Services;
use App\Constant\UserRole;
use App\Models\Room;
use App\Models\User;

class RoomService extends BaseService{
    public function __construct(Room $room)
    {
        $this->model = $room;
    }
}