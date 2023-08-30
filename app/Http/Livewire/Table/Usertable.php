<?php

namespace App\Http\Livewire\Table;
use App\Constant\UserRole;
use App\Constant\UserStatus;
use App\Models\User;

class Usertable extends Table
{
    protected function getData() {
        $filterValues = $this->getFilterValues();
        
        $filters = $filterValues['filters'];
        $roles = $filters['role'];
        $statuses = $filters['status'];
        $sort = $filterValues['sort'];
        $search = $filterValues['search'];

        $users = User::selectColumns(['id', 'role', 'status', 'email', 'username', 'image_url as username_image_url'])
            ->filter('role', $roles)
            ->filter('status', $statuses)
            ->search($search)
            ->orderBy($sort['column'], $sort['type'])
            ->paginate($filterValues['perPage']);

        // $users = $this->constantService->mappingConstant(UserRole::class, 'role', $users);

        // $users = $this->constantService->mappingConstant(UserStatus::class, 'status', $users);

        return $users;
    }
}
