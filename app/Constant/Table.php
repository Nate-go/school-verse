<?php

namespace App\Constant;
use App\Services\UserService;

class Table{
    const SELECTED = 0;
    const NON_SELECTED = 1;

    const TEXT_TYPE = 0;
    const IMG_TYPE = 1;

    const USER_TABLE = [
        'name' => 'users',
        'header' => [
            ['name' => '', 'attributesName' => ['profile', 'image_url'], 'type' => self::IMG_TYPE],
            ['name' => 'username', 'attributesName' => ['profile', 'username'], 'type' => self::TEXT_TYPE],
            ['name' => 'email', 'attributesName' => ['email'], 'type' => self::TEXT_TYPE],
            ['name' => 'role', 'attributesName' => ['role'], 'type' => self::TEXT_TYPE],
            ['name' => 'status', 'attributesName' => ['status'], 'type' => self::TEXT_TYPE]
        ],
        'filterConstants' => [UserRole::class, UserStatus::class],
        'dataSource' => ['model' => UserService::class, 'method' => 'getTable']
    ];
}