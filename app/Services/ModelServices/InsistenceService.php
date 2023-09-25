<?php

namespace App\Services\ModelServices;

use App\Constant\TableData;
use App\Models\Insistence;

class InsistenceService extends BaseService
{
    protected $schoolYearService;

    public function __construct(SchoolYearService $schoolYearService)
    {
        parent::__construct();
        $this->schoolYearService = $schoolYearService;
    }

    public function getModel()
    {
        return Insistence::class;
    }

    public function getPageForAdmin()
    {
        $data = TableData::INSISTENCES;
        $this->tableService->setTableForm($data);

        return view('admin/insistence/insistences', ['tableSource' => $data]);
    }

    public function getPageForUser($id)
    {
        $data = TableData::USER_INSISTENCES;
        $this->tableService->setTableForm($data);
        return view('user/insistences', ['tableSource' => $data, 'userId' => $id]);
    }

    public function getDetailPageForAdmin($id) {
        if(!$this->isInsistenceExist($id)) {
            return redirect()->route('notFound');
        }
        return view('admin/insistence/insistences-detail', ['id' => $id]);
    }

    public function getCreatePage($userId) {
        return view('user/insistences-initialization', ['userId' => $userId]);
    }

    private function isInsistenceExist($id) {
        return Insistence::where('id', $id)->exists();
    }
}
