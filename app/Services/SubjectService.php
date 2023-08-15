<?php

namespace App\Services;
use App\Constant\UserRole;
use App\Models\Subject;
use App\Models\User;

class SubjectService extends BaseService{
    public function __construct(Subject $subject)
    {
        $this->model = $subject;
    }
}