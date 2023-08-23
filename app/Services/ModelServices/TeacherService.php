<?php

namespace App\Services\ModelServices;

use App\Models\RoomTeachers;

class TeacherService extends BaseService
{
    protected function getModel()
    {
        return RoomTeachers::class;
    }
}
