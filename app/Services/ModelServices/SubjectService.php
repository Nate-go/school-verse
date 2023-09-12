<?php

namespace App\Services\ModelServices;

use App\Constant\TableData;
use App\Models\Subject;

class SubjectService extends BaseService
{
    public function getModel()
    {
        return Subject::class;
    }

    public function getPageForAdmin()
    {
        $data = TableData::SUBJECTS;
        $this->tableService->setTableForm($data);

        return view('admin/subject/subjects', ['tableSource' => $data]);
    }

    public function getInitizationForm()
    {
        return view('admin/subject/subjects-initialization');
    }
}
