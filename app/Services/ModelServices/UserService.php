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

        $users = $this->model->selectColumns(['id', 'role', 'status', 'email'])
            ->role($roles)->status($statuses)
            ->with([
                'profile' => function ($query) use ($sort) {
                    $query->selectColumns(['id', 'user_id', 'username', 'image_url'])->sort($sort);
                }
            ])
            ->sort($sort)
            ->paginate($filterData['perPage']);

        $users = ConstantService::mappingConstant(UserRole::class, 'role', $users);

        $users = ConstantService::mappingConstant(UserStatus::class, 'status', $users);

        return $users;
    }
}