<?php

namespace App\Services;
use App\Constant\UserRole;
use App\Models\Exam;
use App\Models\User;

class ExamService extends BaseService{

    public function __construct(Exam $exam){
        $this->model = $exam;
    }
}