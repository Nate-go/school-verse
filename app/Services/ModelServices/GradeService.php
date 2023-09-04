<?php

namespace App\Services\ModelServices;

use App\Models\Grade;

class GradeService extends BaseService
{
    public function getModel()
    {
        return Grade::class;
    }

    public function getGradesJson() {
        $grades = $this->model->selectColumns(['id as value', 'name'])->get();

        return $this->utilService->getJsonData($grades);
    }
}
