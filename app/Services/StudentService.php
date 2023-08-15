<?php

namespace App\Services;
use App\Constant\UserRole;
use App\Models\RoomStudents;
use App\Models\User;

class StudentService extends BaseService{
    public function __construct(RoomStudents $roomStudents)
    {
        $this->model = $roomStudents;
    }
}