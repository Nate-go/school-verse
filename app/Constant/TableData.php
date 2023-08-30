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
            ['name' => 'user', 'attributesName' => 'username', 'type' => HeaderTypes::MIX_TYPE, 'sortable' => true],
            ['name' => 'email', 'attributesName' => 'email', 'type' => HeaderTypes::TEXT_TYPE, 'sortable' => true],
            ['name' => 'role', 'attributesName' => 'role', 'type' => HeaderTypes::TEXT_TYPE, 'sortable' => true],
            ['name' => 'status', 'attributesName' => 'status', 'type' => HeaderTypes::TEXT_TYPE, 'sortable' => true],
        ],
        'filterForm' => [
            'search' => [
                'elements' => [
                    ['column' => 0, 'types' => [CompareTypes::CONTAIN, CompareTypes::EQUAL]],
                    ['column' => 1, 'types' => [CompareTypes::CONTAIN, CompareTypes::EQUAL]]
                ],
                'value' => ['element' => 0, 'type' => 0, 'value' => '']
            ],
            'perPage' => 10,
            'sort' => [
                'column' => 0,
                'type' => SortTypes::DECREASE_SORT,
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
    ];

    const INSISTENCES = [
        'name' => 'insistences',
        'header' => [
            ['name' => 'username', 'attributesName' => 'username', 'type' => TableSetting::USER_TYPE, 'sortable' => true, 'searchable' => true, 'searchType' => [CompareTypes::CONTAIN, CompareTypes::EQUAL]],
            ['name' => 'status', 'attributesName' => 'status', 'type' => HeaderTypes::TEXT_TYPE, 'sortable' => true, 'searchable' => false],
            ['name' => 'role', 'attributesName' => 'role', 'type' => HeaderTypes::TEXT_TYPE, 'sortable' => true, 'searchable' => false],
            ['name' => 'time', 'attributesName' => 'created_at', 'type' => HeaderTypes::TEXT_TYPE, 'sortable' => true, 'searchable' => true, 'searchType' => [CompareTypes::EQUAL, TableSetting::BETWEEN_INCLUDE, TableSetting::GREATER_EQUAL, TableSetting::SMALLER_EQUAL]],
            ['name' => 'content', 'attributesName' => 'content', 'type' => TableSetting::TEXTARE_TYPE, 'sortable' => false, 'searchable' => false],
        ],
        'dataSource' => ['model' => InsistenceService::class, 'method' => 'getTable'],
        'filterForm' => [
            'search' => [
                'columnName' => 'username',
                'type' => CompareTypes::CONTAIN,
                'data' => '',
            ],
            'perPage' => 10,
            'sort' => [
                'columnName' => 'created_at',
                'displayName' => 'time',
                'type' => SortTypes::DECREASE_SORT,
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
    ];

    const ROOMS = [
        'name' => 'rooms',
        'header' => [
            ['name' => '', 'attributesName' => 'image_url', 'type' => TableSetting::USER_TYPE, 'sortable' => false, 'searchable' => false],
            ['name' => 'username', 'attributesName' => 'username', 'type' => TableSetting::USER_TYPE, 'sortable' => true, 'searchable' => true, 'searchType' => [CompareTypes::CONTAIN, CompareTypes::EQUAL]],
            ['name' => 'status', 'attributesName' => 'status', 'type' => HeaderTypes::TEXT_TYPE, 'sortable' => true, 'searchable' => false],
            ['name' => 'role', 'attributesName' => 'role', 'type' => HeaderTypes::TEXT_TYPE, 'sortable' => true, 'searchable' => false],
            ['name' => 'time', 'attributesName' => 'created_at', 'type' => HeaderTypes::TEXT_TYPE, 'sortable' => true, 'searchable' => true, 'searchType' => [CompareTypes::EQUAL, TableSetting::BETWEEN_INCLUDE, TableSetting::GREATER_EQUAL, TableSetting::SMALLER_EQUAL]],
            ['name' => 'content', 'attributesName' => 'content', 'type' => TableSetting::TEXTARE_TYPE, 'sortable' => false, 'searchable' => false],
        ],
        'dataSource' => ['model' => InsistenceService::class, 'method' => 'getTable'],
        'filterForm' => [
            'search' => [
                'columnName' => 'username',
                'type' => CompareTypes::CONTAIN,
                'data' => '',
            ],
            'perPage' => 10,
            'sort' => [
                'columnName' => 'created_at',
                'displayName' => 'time',
                'type' => SortTypes::DECREASE_SORT,
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
