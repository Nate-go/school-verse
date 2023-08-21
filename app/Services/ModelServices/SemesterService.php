<?php

namespace App\Services\ModelServices;
use App\Models\Semester;

class SemesterService extends BaseService{
    public function getModel()
    {
        return Semester::class;
    }
}