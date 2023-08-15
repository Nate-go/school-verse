<?php

namespace App\Services;
use App\Constant\UserRole;
use App\Models\Grade;
use App\Models\User;

class GradeService extends BaseService {

    public function __construct(Grade $grade)
    {
        $this->model = $grade;
    }
}