<?php

namespace App\Services\ModelServices;

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

    public function getTable($filterData)
    {
        $filterElements = $filterData['filterElements'];
        $statuses = $filterElements['status'];
        $roles = $filterElements['role'];
        $schoolYears = $filterElements['schoolYear'];
        $sort = $filterData['sort'];
        $search = $filterData['search'];

        $schoolYearRanges = $this->schoolYearService->getRanges($schoolYears);

        $insistences = $this->model->selectColumns(['insistences.id', 'username','role', 'insistences.status', 'content', 'insistences.created_at', 'image_url'])
            ->join('users', 'insistences.user_id', 'users.id')
            ->filter('insistences.status', $statuses)
            ->filter('role', $roles)
            ->inSchoolYears('insistences.created_at', $schoolYearRanges)
            ->search($search)
            ->orderBy($sort['columnName'], $sort['type'])
            ->paginate($filterData['perPage']);

        $insistences = $this->constantService->mappingConstant(UserRole::class, 'role', $insistences);

        $insistences = $this->constantService->mappingConstant(\App\Constant\Insistence::class, 'status', $insistences);

        return $insistences;
    }

    public function getPageForAdmin() {
        return view('admin/insistence/insistences', ['insistencesSource' => 'INSISTENCES']);
    }

    public function getPageForUser($id)
    {
        return view('admin/insistence/insistences', ['insistencesSource' => 'INSISTENCES']);
    }
}
