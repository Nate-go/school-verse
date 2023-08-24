<?php

namespace App\Services\ModelServices;

use App\Models\Room;
use App\Models\Semester;
use Carbon\Carbon;

class RoomService extends BaseService
{
    public function getModel()
    {
        return Room::class;
    }

    public function getRoomJson()
    {
        
    }
}
