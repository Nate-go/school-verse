<?php

namespace App\Services;
use App\Constant\UserRole;
use App\Constant\UserStatus;
use App\Models\Profile;
use App\Models\User;

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

    public function getTable() {

        $users = $this->profileModel
       ->with('user')
        ;

        dd($users->getQuery()->toSql());

        $users = $this->mappingConstant(UserRole::class, 'role', $users);

        $users = $this->mappingConstant(UserStatus::class, 'status', $users);
        return $users;
    }
}