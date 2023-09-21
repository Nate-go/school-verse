<?php

namespace App\Http\Livewire\Table;

use App\Constant\UserRole;
use App\Models\Insistence;

class Userinsistencetable extends Table
{
    protected function getData()
    {
        $filterValues = $this->getFilterValues();

        $filters = $filterValues['filters'];
        $statuses = $filters['status'];
        $sort = $filterValues['sort'];
        $search = $filterValues['search'];

        $schoolYears = $filters['school year'];

        $insistences = Insistence::selectColumns(['insistences.id as id', 'insistences.status', 'content', 'insistences.created_at'])
            ->join('users', 'insistences.user_id', 'users.id')
            ->where('users.id', $this->userId)
            ->filter($this->getElementFilters(['insistences.status'], [$statuses]))
            ->inSchoolYears('insistences.created_at', $schoolYears)
            ->search($search)
            ->orderBy($sort['column'], $sort['type'])
            ->paginate($filterValues['perPage']);
        

        $insistences = $this->constantService->mappingConstant(\App\Constant\Insistence::class, 'status', $insistences);

        return $insistences;
    }
}
