<?php

namespace App\Services\ModelServices;

use App\Models\Grade;

class GradeService extends BaseService
{
    public function getModel()
    {
        return Grade::class;
    }
}
