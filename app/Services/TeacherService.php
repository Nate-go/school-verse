<?php

namespace App\Services;
use App\Constant\UserRole;
use App\Models\RoomTeachers;
use App\Models\User;

class TeacherService extends BaseService{
    protected function getModel(){
        return RoomTeachers::class;
    }
}