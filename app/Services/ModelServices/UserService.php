<?php

namespace App\Services\ModelServices;

use App\Constant\UserRole;
use App\Constant\UserStatus;
use App\Models\Profile;
use App\Models\User;
use App\Services\ConstantService;
use Carbon\Carbon;
use DB;

class UserService extends BaseService
{
    protected $profileModel;

    public function __construct(Profile $profileModel)
    {
        parent::__construct();
        $this->profileModel = $profileModel;
    }

    protected function getModel()
    {
        return User::class;
    }

    public function getTable($filterData)
    {
        $filterElements = $filterData['filterElements'];
        $roles = $filterElements['role'];
        $statuses = $filterElements['status'];
        $sort = $filterData['sort'];
        $search = $filterData['search'];

        $users = $this->model->selectColumns(['id', 'role', 'status', 'email', 'username', 'image_url'])
            ->filter('role', $roles)
            ->filter('status', $statuses)
            ->search($search)
            ->orderBy($sort['columnName'], $sort['type'])
            ->paginate($filterData['perPage']);

        $users = $this->constantService->mappingConstant(UserRole::class, 'role', $users);

        $users = $this->constantService->mappingConstant(UserStatus::class, 'status', $users);
        return $users;
    }

    public function getPageForAdmin()
    {
        return view('admin/user/users', ['userSource' => 'USERS']);
    }

    public function softDelete($id) {
        $this->model->update(['deleted_at' => Carbon::now()])->where('id', $id);
    }
}
