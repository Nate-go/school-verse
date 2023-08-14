<?php

namespace App\Services;
use App\Constant\UserRole;
use App\Models\User;

class UserService{
    public function getAllUsers() {
        $users = User::join('profiles', 'users.id', '=', 'profiles.user_id')
            ->select('users.id', 'users.role', 'users.status', 'users.email', 'profiles.username', 'profiles.img')
            ->get();

        return $users;
    }

    public function getAllTeacher() {
        $teachers = User::join('profiles', 'users.id', '=', 'profiles.user_id')->where('users.role', UserRole::TEACHER)
            ->select('users.id', 'users.email', 'profiles.username', 'profiles.img')
            ->get();

        return $teachers;
    }
}