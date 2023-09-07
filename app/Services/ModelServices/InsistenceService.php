<?php

namespace App\Services\ModelServices;

use App\Constant\TableData;
use App\Constant\UserRole;
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

    public function getPageForAdmin() {
        $data = TableData::INSISTENCES;
        $this->tableService->setTableForm($data);
        return view('admin/insistence/insistences', ['tableSource' => $data]);
    }

    public function getPageForUser($id)
    {
        return view('admin/insistence/insistences', ['insistencesSource' => 'INSISTENCES']);
    }
}
