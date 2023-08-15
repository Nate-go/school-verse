<?php

namespace App\Services;
use App\Constant\UserRole;
use App\Models\User;

class StudentService extends BaseService{
    public function __construct()
    {
        $this->table = 'room_students';
    }
}