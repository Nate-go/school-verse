<?php

namespace App\Services\ModelServices;
use App\Constant\UserRole;
use App\Constant\UserStatus;
use App\Models\Profile;
use App\Models\User;
use App\Services\ConstantService;

class UserService extends BaseService{

    protected $profileModel;

    public function __construct(Profile $profileModel){
        parent::__construct();
        $this->profileModel = $profileModel;
    }

    protected function getModel()
    {
        return User::class;
    }

    public function getTable($filterData) {

        $filterElements = $filterData['filterElements'];
        $roles = $filterElements['role'];
        $statuses = $filterElements['status'];
        $sort = $filterData['sort'];
        $search = $filterData['search'];

        $users = $this->model->selectColumns(['users.id', 'role', 'status', 'email', 'username', 'image_url'])
            ->role($roles)
            ->status($statuses)
            ->join('profiles', 'users.id', 'profiles.user_id')
            ->search($search)
            ->orderBy($sort['columnName'], $sort['type'])
            ->paginate($filterData['perPage']);

        $users = ConstantService::mappingConstant(UserRole::class, 'role', $users);

        $users = ConstantService::mappingConstant(UserStatus::class, 'status', $users);

        return $users;
    }
}