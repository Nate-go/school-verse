<?php

namespace App\Services;
use App\Constant\UserRole;
use App\Models\User;

class TeacherService extends BaseService{
    public function __construct()
    {
        $this->table = 'subject_teachers';
    }
}