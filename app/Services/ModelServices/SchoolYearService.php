<?php

namespace App\Services\ModelServices;

use App\Constant\TableData;
use App\Models\SchoolYear;
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

    public function getPageForAdmin()
    {
        $data = TableData::SCHOOLYEARS;
        $this->tableService->setTableForm($data);
        return view('admin/school-year/school-years', ['tableSource' => $data]);
    }

    public function getCurrentSchoolYear() {
        $currentTime = Carbon::now();
        $currentSchoolYear = $this->model->selectColumns(['id'])->where('start_at', '<=', $currentTime)->where('end_at', '>=', $currentTime)->first();

        return $currentSchoolYear ? $currentSchoolYear->id : null; 
    }
}
