<?php

namespace App\Constant;
use App\Services\ConstantService;
use App\Services\ModelServices\UserService;

class TableData{ 
    const USERS = [
        'name' => 'users',
        'header' => [
            ['name' => '', 'attributesName' => 'image_url', 'type' => TableSetting::IMG_TYPE, 'sortable' => false, 'searchable' => false ],
            ['name' => 'username', 'attributesName' => 'username', 'type' => TableSetting::TEXT_TYPE, 'sortable' => true, 'searchable' => true, 'searchType' => [TableSetting::CONTAIN, TableSetting::EQUAL]],
            ['name' => 'email', 'attributesName' => 'email', 'type' => TableSetting::TEXT_TYPE, 'sortable' => true, 'searchable' => true, 'searchType' => [TableSetting::CONTAIN, TableSetting::EQUAL]],
            ['name' => 'role', 'attributesName' => 'role', 'type' => TableSetting::TEXT_TYPE, 'sortable' => true, 'searchable' => false],
            ['name' => 'status', 'attributesName' => 'status', 'type' => TableSetting::TEXT_TYPE, 'sortable' => true, 'searchable' => false]
        ],
        'dataSource' => ['model' => UserService::class, 'method' => 'getTable'],
        'filterForm' => [
            'search' => [
                'columnName' => 'email',
                'type' => TableSetting::CONTAIN,
                'data' => 'english'
            ],
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