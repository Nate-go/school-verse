<?php

namespace App\Services\ModelServices;
use App\Models\Room;

class RoomService extends BaseService{
    public function getModel()
    {
        return Room::class;
    }
}