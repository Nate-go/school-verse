<?php

namespace App\Services;
use App\Constant\UserRole;
use App\Models\User;

class UserService extends BaseService{
    public function __construct()
    {
        $this->table = 'users';
    }

    public function getAll() {
        $users = User::join('profiles', 'users.id', '=', 'profiles.user_id')
            ->select('users.id', 'users.role', 'users.status', 'users.email', 'profiles.username', 'profiles.img')
            ->get();

        return $users;
    }
}