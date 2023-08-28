<?php

namespace App\Services\ModelServices;

use App\Models\SchoolYear;
use App\Services\UtilService;

class SchoolYearService extends BaseService
{
    public function getModel()
    {
        return SchoolYear::class;
    }

    public function getSchoolYearJson() {
        $schoolYears = $this->model->selectColumns(['id as value', 'name'])->get();

        return $this->utilService->getJsonData($schoolYears);
    }
}
