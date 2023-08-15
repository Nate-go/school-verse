<?php

namespace App\Services;
use App\Constant\UserRole;
use App\Models\Semester;
use App\Models\User;

class SemesterService extends BaseService{
    public function __construct(Semester $semester)
    {
        $this->model = $semester;
    }
}