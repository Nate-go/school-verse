<?php

namespace App\Services;
use App\Constant\UserRole;
use App\Constant\UserStatus;
use App\Models\Profile;
use App\Models\User;
use DB;

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

        $users = $this->model
            ->with([
                'profile' => function ($query) {
                    return $query->select(['id', 'user_id', 'username', 'image_url']);
                }
            ])
            ->when(!empty($roles), function ($query, $filterData) {
                return $query->whereIn('role', $filterData['UserRole']);
            })
            ->when(!empty($statuses), function ($query, $filterData) {
                return $query->whereIn('status', $filterData['UserStatus']);
            })
            ->select(['id', 'role', 'status', 'email'])
            ->paginate(10);

        // $users = DB::table('users')
        //     ->select(['id', 'role', 'status', 'email'])
        //     ->when(!empty($roles), function ($query, $filterData) {
        //         return $query->whereIn('role', $$filterData['UserRole']);
        //     })
        //     ->when(!empty($statuses), function ($query, $filterData) {
        //         return $query->whereIn('status', $filterData['UserStatus']);
        //     })
        //     ->when(true, function ($query) {
        //         return $query->join('profiles', 'users.id', '=', 'profiles.user_id')
        //             ->select(['users.id', 'users.role', 'users.status', 'users.email', 'profiles.id', 'profiles.user_id', 'profiles.username', 'profiles.image_url']);
        //     })
        //     ->paginate(10);


        $users = self::mappingConstant(UserRole::class, 'role', $users);

        $users = self::mappingConstant(UserStatus::class, 'status', $users);
        return $users;
    }
}