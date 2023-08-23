<?php

namespace App\Services\ModelServices;

use App\Models\Subject;

class SubjectService extends BaseService
{
    public function getModel()
    {
        return Subject::class;
    }
}
