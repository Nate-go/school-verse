<?php

namespace App\Services\ModelServices;

use App\Constant\TableData;
use App\Models\Teacher;

class TeacherService extends BaseService
{
    protected function getModel()
    {
        return Teacher::class;
    }

    public function getPageForAdmin()
    {
        $data = TableData::TEACHERS;
        $this->tableService->setTableForm($data);

        return view('admin/teacher/teachers', ['tableSource' => $data]);
    }

    public function getInitizationForm()
    {
        return view('admin/teacher/teachers-initialization');
    }
}
