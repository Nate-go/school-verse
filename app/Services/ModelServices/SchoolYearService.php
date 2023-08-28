<?php

namespace App\Services\ModelServices;

use App\Models\SchoolYear;
use App\Services\UtilService;
use Carbon\Carbon;

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

    public function getRange($schoolYearId) {
        $schoolYear = $this->model->find($schoolYearId);

        return $schoolYear ? [$schoolYear->start_at, $schoolYear->end_at] : null;
    }

    public function getRanges($schoolYearIds) {
        $schoolYears = $this->model->whereIn('id', $schoolYearIds)->get();

        $schoolYearRanges = [];
        foreach($schoolYears as $schoolYear) {
            $schoolYearRanges[] = [$schoolYear->start_at, $schoolYear->end_at];
        }
        return $schoolYearRanges;
    }

    public function getCurrentSchoolYear() {
        $currentTime = Carbon::now();
        $currentSchoolYear = $this->model->selectColumns(['id'])->where('start_at', '<=', $currentTime)->where('end_at', '>=', $currentTime)->first();

        return $currentSchoolYear ? $currentSchoolYear->id : null; 
    }
}
