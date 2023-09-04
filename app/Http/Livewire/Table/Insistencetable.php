<?php

namespace App\Http\Livewire\Table;
use App\Constant\UserRole;
use App\Models\Insistence;


class Insistencetable extends Table
{
    protected function getData() {
        $filterValues = $this->getFilterValues();
        
        $filters = $filterValues['filters'];
        $roles = $filters['role'];
        $statuses = $filters['status'];
        $sort = $filterValues['sort'];
        $search = $filterValues['search'];

        $schoolYears = $filters['school year'];

        $insistences = Insistence::selectColumns(['insistences.id as id', 'username', 'role', 'insistences.status', 'content', 'insistences.created_at', 'image_url as username_image_url'])
            ->join('users', 'insistences.user_id', 'users.id')
            ->filter('insistences.status', $statuses)
            ->filter('role', $roles)
            ->inSchoolYears('insistences.created_at', $schoolYears)
            ->search($search)
            ->orderBy($sort['column'], $sort['type'])
            ->paginate($filterValues['perPage']);

        $insistences = $this->constantService->mappingConstant(UserRole::class, 'role', $insistences);

        $insistences = $this->constantService->mappingConstant(\App\Constant\Insistence::class, 'status', $insistences);

        return $insistences;
    }

    public function delete($userId) {
        
    }
}
