<?php

namespace App\Services\ModelServices;
use App\Models\Exam;

class ExamService extends BaseService{
    public function getModel(){
        return Exam::class;
    }
}