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

    public function getDetailPageForAdmin($id)
    {
        if(!$this->isSubjectExist($id)) {
            return redirect()->route('notFound');
        }
        return view('admin/subject/subjects-detail', ['id' => $id]);
    }

    private function isSubjectExist($subjectId) {
        return Subject::where('id', $subjectId)->exist();
    }
}
