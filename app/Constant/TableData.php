<?php

namespace App\Constant;

use App\Services\ConstantService;
use App\Services\ModelServices\InsistenceService;
use App\Services\ModelServices\RoomService;
use App\Services\ModelServices\SchoolYearService;
use App\Services\ModelServices\UserService;
use App\Services\UtilService;

class TableData
{
    const USERS = [
        'name' => 'users',
        'header' => [
            ['name' => '', 'attributesName' => 'image_url', 'type' => TableSetting::USER_TYPE, 'sortable' => false, 'searchable' => false],
            ['name' => 'username', 'attributesName' => 'username', 'type' => TableSetting::USER_TYPE, 'sortable' => true, 'searchable' => true, 'searchType' => [TableSetting::CONTAIN, TableSetting::EQUAL]],
            ['name' => 'email', 'attributesName' => 'email', 'type' => TableSetting::TEXT_TYPE, 'sortable' => true, 'searchable' => true, 'searchType' => [TableSetting::CONTAIN, TableSetting::EQUAL]],
            ['name' => 'role', 'attributesName' => 'role', 'type' => TableSetting::TEXT_TYPE, 'sortable' => true, 'searchable' => false],
            ['name' => 'status', 'attributesName' => 'status', 'type' => TableSetting::TEXT_TYPE, 'sortable' => true, 'searchable' => false],
        ],
        'dataSource' => ['model' => UserService::class, 'method' => 'getTable'],
        'filterForm' => [
            'search' => [
                'columnName' => 'username',
                'type' => TableSetting::CONTAIN,
                'data' => '',
            ],
            'perPage' => 10,
            'sort' => [
                'columnName' => 'username',
                'displayName' => 'username',
                'type' => TableSetting::DECREASE_SORT,
                'displayType' => 'Decrease',
            ],
            'filterElements' => [
                [
                    'name' => 'role',
                    'resource' => ['model' => ConstantService::class, 'method' => 'getConstantsJson', 'args' => [UserRole::class]],
                    'defaultValues' => [UserRole::STUDENT, UserRole::TEACHER],
                ],
                [
                    'name' => 'status',
                    'resource' => ['model' => ConstantService::class, 'method' => 'getConstantsJson', 'args' => [UserStatus::class]],
                    'defaultValues' => [UserStatus::ACTIVE],
                ],
            ],
        ],
        'actions' => [
            'detail' => '/users/',
            'delete' => '/users/'
        ]
    ];

    const INSISTENCES = [
        'name' => 'insistences',
        'header' => [
            ['name' => '', 'attributesName' => 'image_url', 'type' => TableSetting::USER_TYPE, 'sortable' => false, 'searchable' => false],
            ['name' => 'username', 'attributesName' => 'username', 'type' => TableSetting::USER_TYPE, 'sortable' => true, 'searchable' => true, 'searchType' => [TableSetting::CONTAIN, TableSetting::EQUAL]],
            ['name' => 'status', 'attributesName' => 'status', 'type' => TableSetting::TEXT_TYPE, 'sortable' => true, 'searchable' => false],
            ['name' => 'role', 'attributesName' => 'role', 'type' => TableSetting::TEXT_TYPE, 'sortable' => true, 'searchable' => false],
            ['name' => 'time', 'attributesName' => 'created_at', 'type' => TableSetting::TEXT_TYPE, 'sortable' => true, 'searchable' => true, 'searchType' => [TableSetting::EQUAL, TableSetting::BETWEEN_INCLUDE, TableSetting::GREATER_EQUAL, TableSetting::SMALLER_EQUAL]],
            ['name' => 'content', 'attributesName' => 'content', 'type' => TableSetting::TEXTARE_TYPE, 'sortable' => false, 'searchable' => false],
        ],
        'dataSource' => ['model' => InsistenceService::class, 'method' => 'getTable'],
        'filterForm' => [
            'search' => [
                'columnName' => 'username',
                'type' => TableSetting::CONTAIN,
                'data' => '',
            ],
            'perPage' => 10,
            'sort' => [
                'columnName' => 'created_at',
                'displayName' => 'time',
                'type' => TableSetting::DECREASE_SORT,
                'displayType' => 'Decrease',
            ],
            'filterElements' => [
                [
                    'name' => 'schoolYear',
                    'resource' => ['model' => SchoolYearService::class, 'method' => 'getSchoolYearJson', 'args' => []],
                    'defaultValues' => [],
                ],
                [
                    'name' => 'status',
                    'resource' => ['model' => ConstantService::class, 'method' => 'getConstantsJson', 'args' => [Insistence::class]],
                    'defaultValues' => [Insistence::PENDING],
                ],
                [
                    'name' => 'role',
                    'resource' => ['model' => ConstantService::class, 'method' => 'getConstantsJson', 'args' => [UserRole::class]],
                    'defaultValues' => [UserRole::STUDENT, UserRole::TEACHER],
                ]
            ]
        ],
        'actions' => [
            'detail' => '/users/',
            'delete' => '/users/'
        ]
    ];

    const ROOMS = [
        'name' => 'rooms',
        'header' => [
            ['name' => '', 'attributesName' => 'image_url', 'type' => TableSetting::USER_TYPE, 'sortable' => false, 'searchable' => false],
            ['name' => 'username', 'attributesName' => 'username', 'type' => TableSetting::USER_TYPE, 'sortable' => true, 'searchable' => true, 'searchType' => [TableSetting::CONTAIN, TableSetting::EQUAL]],
            ['name' => 'status', 'attributesName' => 'status', 'type' => TableSetting::TEXT_TYPE, 'sortable' => true, 'searchable' => false],
            ['name' => 'role', 'attributesName' => 'role', 'type' => TableSetting::TEXT_TYPE, 'sortable' => true, 'searchable' => false],
            ['name' => 'time', 'attributesName' => 'created_at', 'type' => TableSetting::TEXT_TYPE, 'sortable' => true, 'searchable' => true, 'searchType' => [TableSetting::EQUAL, TableSetting::BETWEEN_INCLUDE, TableSetting::GREATER_EQUAL, TableSetting::SMALLER_EQUAL]],
            ['name' => 'content', 'attributesName' => 'content', 'type' => TableSetting::TEXTARE_TYPE, 'sortable' => false, 'searchable' => false],
        ],
        'dataSource' => ['model' => InsistenceService::class, 'method' => 'getTable'],
        'filterForm' => [
            'search' => [
                'columnName' => 'username',
                'type' => TableSetting::CONTAIN,
                'data' => '',
            ],
            'perPage' => 10,
            'sort' => [
                'columnName' => 'created_at',
                'displayName' => 'time',
                'type' => TableSetting::DECREASE_SORT,
                'displayType' => 'Decrease',
            ],
            'filterElements' => [
                [
                    'name' => 'schoolYear',
                    'resource' => ['model' => SchoolYearService::class, 'method' => 'getSchoolYearJson', 'args' => []],
                    'defaultValues' => [],
                ],
                [
                    'name' => 'status',
                    'resource' => ['model' => ConstantService::class, 'method' => 'getConstantsJson', 'args' => [Insistence::class]],
                    'defaultValues' => [Insistence::PENDING],
                ],
                [
                    'name' => 'role',
                    'resource' => ['model' => ConstantService::class, 'method' => 'getConstantsJson', 'args' => [UserRole::class]],
                    'defaultValues' => [UserRole::STUDENT, UserRole::TEACHER],
                ]
            ]
        ],
        'actions' => [
            'detail' => '/users/',
            'delete' => '/users/'
        ]
    ];
}
