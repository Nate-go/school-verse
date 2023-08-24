<?php

namespace App\Services\ModelServices;

use App\Constant\UserRole;
use App\Models\Insistence;

class InsistenceService extends BaseService
{
    public function getModel()
    {
        return Insistence::class;
    }

    public function getTable($filterData)
    {
        $filterElements = $filterData['filterElements'];
        $statuses = $filterElements['status'];
        $roles = $filterElements['role'];
        $sort = $filterData['sort'];
        $search = $filterData['search'];

        $insistences = $this->model->selectColumns(['insistences.id', 'username','role', 'insistences.status', 'content', 'insistences.created_at', 'image_url'])
            ->join('users', 'insistences.user_id', 'users.id')
            ->whereIn('insistences.status', $statuses)
            ->whereIn('role', $roles)
            ->search($search)
            ->orderBy($sort['columnName'], $sort['type'])
            ->paginate($filterData['perPage']);

        $insistences = $this->constantService->mappingConstant(UserRole::class, 'role', $insistences);

        $insistences = $this->constantService->mappingConstant(\App\Constant\Insistence::class, 'status', $insistences);

        return $insistences;
    }
}
