<?php

namespace App\Constant;
use App\Services\ConstantService;
use App\Services\ModelServices\UserService;

class TableData{ 
    const USERS = [
        'name' => 'users',
        'header' => [
            ['name' => '', 'attributesName' => ['profile', 'image_url'], 'type' => TableSetting::IMG_TYPE, 'sortable' => false],
            ['name' => 'username', 'attributesName' => ['profile', 'username'], 'type' => TableSetting::TEXT_TYPE, 'sortable' => true],
            ['name' => 'email', 'attributesName' => ['email'], 'type' => TableSetting::TEXT_TYPE, 'sortable' => true],
            ['name' => 'role', 'attributesName' => ['role'], 'type' => TableSetting::TEXT_TYPE, 'sortable' => true],
            ['name' => 'status', 'attributesName' => ['status'], 'type' => TableSetting::TEXT_TYPE, 'sortable' => true]
        ],
        'dataSource' => ['model' => UserService::class, 'method' => 'getTable'],
        'filterForm' => [
            'perPage' => 10,
            'sort' => [
                'columnName' => 'username',
                'displayName' => 'username',
                'type' => TableSetting::DECREASE_SORT,
                'displayType' => 'Decrease'
            ],
            'filterElements' => [
                [
                    'name' => 'role', 
                    'resource' => ['model' => ConstantService::class, 'method' => 'getConstantsJson', 'args' => [UserRole::class] ],
                    'defaultValues' => [UserRole::STUDENT, UserRole::TEACHER]
                ],
                [
                    'name' => 'status',
                    'resource' => ['model' => ConstantService::class, 'method' => 'getConstantsJson', 'args' => [UserStatus::class]],
                    'defaultValues' => [UserStatus::ACTIVE]
                ]
            ]
        ]
    ];
}