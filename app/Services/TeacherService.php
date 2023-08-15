<?php

namespace App\Services;
use App\Constant\UserRole;
use App\Models\RoomTeachers;
use App\Models\User;

class TeacherService extends BaseService{
    public function __construct(RoomTeachers $roomTeachers)
    {
        $this->model = $roomTeachers;
    }
}