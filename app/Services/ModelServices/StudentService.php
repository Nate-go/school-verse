<?php

namespace App\Services\ModelServices;
use App\Models\RoomStudents;

class StudentService extends BaseService{
    public function getModel()
    {
        return RoomStudents::class;
    }
}