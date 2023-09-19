<?php

namespace App\Services\ModelServices;

use App\Constant\TableData;
use App\Models\Grade;

class GradeService extends BaseService
{
    public function getModel()
    {
        return Grade::class;
    }

    public function getGradesJson()
    {
        $grades = $this->model->selectColumns(['id as value', 'name'])->get();

        return $this->utilService->getJsonData($grades);
    }

    public function getPageForAdmin()
    {
        $data = TableData::GRADES;
        $this->tableService->setTableForm($data);

        return view('admin/grade/grades', ['tableSource' => $data]);
    }

    public function getInitizationForm()
    {
        return view('admin/grade/grades-initialization');
    }

    public function getDetailPageForAdmin($id)
    {
        return view('admin/grade/grades-detail', ['id' => $id]);
    }
}
