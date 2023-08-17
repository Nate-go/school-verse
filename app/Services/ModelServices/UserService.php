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
        
        $roles = $filterData['UserRole'];
        $statuses = $filterData['UserStatus'];

        $users = $this->model
            ->with([
                'profile' => function ($query) {
                    return $query->select(['id', 'user_id', 'username', 'image_url']);
                }
            ])
            ->when(!empty($roles), function ($query) use ($roles) {
                return $query->whereIn('role', $roles);
            })
            ->when(!empty($statuses), function ($query) use ($statuses) {
                return $query->whereIn('status', $statuses);
            })
            ->select(['id', 'role', 'status', 'email'])
            ->paginate(10);

        $users = ConstantService::mappingConstant(UserRole::class, 'role', $users);

        $users = ConstantService::mappingConstant(UserStatus::class, 'status', $users);
        return $users;
    }
}