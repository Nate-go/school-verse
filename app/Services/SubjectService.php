<?php

namespace App\Services;
use App\Constant\UserRole;
use App\Models\User;

class SubjectService extends BaseService{
    public function __construct()
    {
        $this->table = 'subjects';
    }
}