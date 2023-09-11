<?php

namespace App\Services\ModelServices;

use App\Constant\TableData;
use App\Models\Student;

class StudentService extends BaseService
{
    public function getModel()
    {
        return Student::class;
    }

    public function getPageForAdmin()
    {
        $data = TableData::STUDENTS;
        $this->tableService->setTableForm($data);

        return view('admin/student/students', ['tableSource' => $data]);
    }

    public function getInitizationForm()
    {
        return view('admin/student/students-initialization');
    }
}
