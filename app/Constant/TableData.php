<?php

namespace App\Constant;

use App\Services\ConstantService;
use App\Services\ModelServices\GradeService;
use App\Services\ModelServices\SchoolYearService;
use App\Services\ModelServices\SubjectService;

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
                    ['column' => 1, 'types' => [CompareTypes::CONTAIN, CompareTypes::EQUAL]],
                ],
                'value' => ['element' => 0, 'type' => 0, 'value' => ''],
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
            ['name' => 'user', 'attributesName' => 'username', 'type' => HeaderTypes::MIX_TYPE, 'sortable' => true],
            ['name' => 'content', 'attributesName' => 'content', 'type' => HeaderTypes::TEXTARE_TYPE, 'sortable' => false],
            ['name' => 'time', 'attributesName' => 'created_at', 'type' => HeaderTypes::TEXT_TYPE, 'sortable' => true],
            ['name' => 'role', 'attributesName' => 'role', 'type' => HeaderTypes::TEXT_TYPE, 'sortable' => true],
            ['name' => 'status', 'attributesName' => 'status', 'type' => HeaderTypes::TEXT_TYPE, 'sortable' => true],
        ],
        'filterForm' => [
            'search' => [
                'elements' => [
                    ['column' => 0, 'types' => [CompareTypes::CONTAIN, CompareTypes::EQUAL]],
                    ['column' => 2, 'types' => [CompareTypes::GREATER_EQUAL, CompareTypes::EQUAL, CompareTypes::SMALLER_EQUAL]],
                ],
                'value' => ['element' => 0, 'type' => 0, 'value' => ''],
            ],
            'perPage' => 8,
            'sort' => [
                'column' => 2,
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
                    'resource' => ['model' => ConstantService::class, 'method' => 'getConstantsJson', 'args' => [Insistence::class]],
                    'defaultValues' => [Insistence::PENDING],
                ],
                [
                    'name' => 'school year',
                    'resource' => ['model' => SchoolYearService::class, 'method' => 'getSchoolYearJson', 'args' => []],
                    'defaultValues' => [],
                ],
            ],
        ],
    ];

    const ROOMS = [
        'name' => 'rooms',
        'header' => [
            ['name' => 'name', 'attributesName' => 'room_name', 'type' => HeaderTypes::MIX_TYPE, 'sortable' => true],
            ['name' => 'homeroom teacher', 'attributesName' => 'username', 'type' => HeaderTypes::MIX_TYPE, 'sortable' => true],
            ['name' => 'number of members', 'attributesName' => 'number_of_members', 'type' => HeaderTypes::TEXT_TYPE, 'sortable' => true],
            ['name' => 'school year', 'attributesName' => 'school_year', 'type' => HeaderTypes::TEXT_TYPE, 'sortable' => true],
            ['name' => 'missed teachers', 'attributesName' => 'missed_teachers', 'type' => HeaderTypes::TEXT_TYPE, 'sortable' => true],
        ],
        'filterForm' => [
            'search' => [
                'elements' => [
                    ['column' => 0, 'types' => [CompareTypes::CONTAIN, CompareTypes::EQUAL]],
                    ['column' => 1, 'types' => [CompareTypes::CONTAIN, CompareTypes::EQUAL]],
                ],
                'value' => ['element' => 0, 'type' => 0, 'value' => ''],
            ],
            'perPage' => 8,
            'sort' => [
                'column' => 4,
                'type' => SortTypes::DECREASE_SORT,
            ],
            'filterElements' => [
                [
                    'name' => 'grade',
                    'resource' => ['model' => GradeService::class, 'method' => 'getGradesJson', 'args' => []],
                    'defaultValues' => [-1],
                ],
                [
                    'name' => 'school year',
                    'resource' => ['model' => SchoolYearService::class, 'method' => 'getSchoolYearJson', 'args' => []],
                    'defaultValues' => [],
                ],
            ],
        ],
    ];

    const SCHOOLYEARS = [
        'name' => 'school years',
        'header' => [
            ['name' => 'name', 'attributesName' => 'name', 'type' => HeaderTypes::TEXT_TYPE, 'sortable' => true],
            ['name' => 'start', 'attributesName' => 'start_at', 'type' => HeaderTypes::TEXT_TYPE, 'sortable' => true],
            ['name' => 'end', 'attributesName' => 'end_at', 'type' => HeaderTypes::TEXT_TYPE, 'sortable' => true],
            ['name' => 'total rooms', 'attributesName' => 'total_rooms', 'type' => HeaderTypes::TEXT_TYPE, 'sortable' => true],
            ['name' => 'total students', 'attributesName' => 'total_students', 'type' => HeaderTypes::TEXT_TYPE, 'sortable' => true],
        ],
        'filterForm' => [
            'search' => [
                'elements' => [
                    ['column' => 0, 'types' => [CompareTypes::CONTAIN, CompareTypes::EQUAL]],
                ],
                'value' => ['element' => 0, 'type' => 0, 'value' => ''],
            ],
            'perPage' => 6,
            'sort' => [
                'column' => 1,
                'type' => SortTypes::DECREASE_SORT,
            ],
            'filterElements' => [

            ],
        ],
    ];

    const GRADES = [
        'name' => 'grades',
        'header' => [
            ['name' => 'name', 'attributesName' => 'name', 'type' => HeaderTypes::TEXT_TYPE, 'sortable' => true],
            ['name' => 'number of subjects', 'attributesName' => 'number_of_subjects', 'type' => HeaderTypes::TEXT_TYPE, 'sortable' => true],
            ['name' => 'number of teachers', 'attributesName' => 'number_of_teachers', 'type' => HeaderTypes::TEXT_TYPE, 'sortable' => true],
        ],
        'filterForm' => [
            'search' => [
                'elements' => [
                    ['column' => 0, 'types' => [CompareTypes::CONTAIN, CompareTypes::EQUAL]],
                ],
                'value' => ['element' => 0, 'type' => 0, 'value' => ''],
            ],
            'perPage' => 8,
            'sort' => [
                'column' => 1,
                'type' => SortTypes::INCREASE_SORT,
            ],
            'filterElements' => [

            ],
        ],
    ];

    const SUBJECTS = [
        'name' => 'subjects',
        'header' => [
            ['name' => 'name', 'attributesName' => 'subject_name', 'type' => HeaderTypes::MIX_TYPE, 'sortable' => true],
            ['name' => 'number of lessons', 'attributesName' => 'number_lesson', 'type' => HeaderTypes::TEXT_TYPE, 'sortable' => true],
            ['name' => 'grade', 'attributesName' => 'grade_name', 'type' => HeaderTypes::TEXT_TYPE, 'sortable' => true],
            ['name' => 'coefficient', 'attributesName' => 'coefficient', 'type' => HeaderTypes::TEXT_TYPE, 'sortable' => true],
            ['name' => 'number of teachers', 'attributesName' => 'number_of_teachers', 'type' => HeaderTypes::TEXT_TYPE, 'sortable' => true],
        ],
        'filterForm' => [
            'search' => [
                'elements' => [
                    ['column' => 0, 'types' => [CompareTypes::CONTAIN, CompareTypes::EQUAL]],
                ],
                'value' => ['element' => 0, 'type' => 0, 'value' => ''],
            ],
            'perPage' => 8,
            'sort' => [
                'column' => 0,
                'type' => SortTypes::INCREASE_SORT,
            ],
            'filterElements' => [
                [
                    'name' => 'grade',
                    'resource' => ['model' => GradeService::class, 'method' => 'getGradesJson', 'args' => []],
                    'defaultValues' => [-1],
                ],
            ],
        ],
    ];

    const TEACHERS = [
        'name' => 'teachers',
        'header' => [
            ['name' => 'name', 'attributesName' => 'username', 'type' => HeaderTypes::MIX_TYPE, 'sortable' => true],
            ['name' => 'number of subject', 'attributesName' => 'number_of_subjects', 'type' => HeaderTypes::TEXT_TYPE, 'sortable' => true],
            ['name' => 'number of room', 'attributesName' => 'number_of_rooms', 'type' => HeaderTypes::TEXT_TYPE, 'sortable' => true],
            ['name' => 'number of homeroom', 'attributesName' => 'number_of_homerooms', 'type' => HeaderTypes::TEXT_TYPE, 'sortable' => true],
            ['name' => 'school year', 'attributesName' => 'school_year', 'type' => HeaderTypes::TEXT_TYPE, 'sortable' => true],
        ],
        'filterForm' => [
            'search' => [
                'elements' => [
                    ['column' => 0, 'types' => [CompareTypes::CONTAIN, CompareTypes::EQUAL]],
                ],
                'value' => ['element' => 0, 'type' => 0, 'value' => ''],
            ],
            'perPage' => 8,
            'sort' => [
                'column' => 0,
                'type' => SortTypes::DECREASE_SORT,
            ],
            'filterElements' => [
                [
                    'name' => 'school year',
                    'resource' => ['model' => SchoolYearService::class, 'method' => 'getSchoolYearJson', 'args' => []],
                    'defaultValues' => [],
                ],
            ],
        ],
    ];

    const STUDENTS = [
        'name' => 'students',
        'header' => [
            ['name' => 'name', 'attributesName' => 'username', 'type' => HeaderTypes::MIX_TYPE, 'sortable' => true],
            ['name' => 'room', 'attributesName' => 'room', 'type' => HeaderTypes::TEXT_TYPE, 'sortable' => true],
            ['name' => 'school year', 'attributesName' => 'school_year', 'type' => HeaderTypes::TEXT_TYPE, 'sortable' => true],
        ],
        'filterForm' => [
            'search' => [
                'elements' => [
                    ['column' => 0, 'types' => [CompareTypes::CONTAIN, CompareTypes::EQUAL]],
                    ['column' => 1, 'types' => [CompareTypes::CONTAIN, CompareTypes::EQUAL]],
                ],
                'value' => ['element' => 0, 'type' => 0, 'value' => ''],
            ],
            'perPage' => 10,
            'sort' => [
                'column' => 0,
                'type' => SortTypes::DECREASE_SORT,
            ],
            'filterElements' => [
                [
                    'name' => 'grade',
                    'resource' => ['model' => GradeService::class, 'method' => 'getGradesJson', 'args' => []],
                    'defaultValues' => [-1],
                ],
                [
                    'name' => 'school year',
                    'resource' => ['model' => SchoolYearService::class, 'method' => 'getSchoolYearJson', 'args' => []],
                    'defaultValues' => [],
                ],
            ],
        ],
    ];

    const USER_INSISTENCES = [
        'name' => 'insistences',
        'header' => [
            ['name' => 'content', 'attributesName' => 'content', 'type' => HeaderTypes::TEXTARE_TYPE, 'sortable' => false],
            ['name' => 'time', 'attributesName' => 'created_at', 'type' => HeaderTypes::TEXT_TYPE, 'sortable' => true],
            ['name' => 'status', 'attributesName' => 'status', 'type' => HeaderTypes::TEXT_TYPE, 'sortable' => true],
        ],
        'filterForm' => [
            'search' => [
                'elements' => [
                    ['column' => 0, 'types' => [CompareTypes::CONTAIN, CompareTypes::EQUAL]],
                ],
                'value' => ['element' => 0, 'type' => 0, 'value' => ''],
            ],
            'perPage' => 8,
            'sort' => [
                'column' => 1,
                'type' => SortTypes::DECREASE_SORT,
            ],
            'filterElements' => [
                [
                    'name' => 'status',
                    'resource' => ['model' => ConstantService::class, 'method' => 'getConstantsJson', 'args' => [Insistence::class]],
                    'defaultValues' => [Insistence::PENDING],
                ],
                [
                    'name' => 'school year',
                    'resource' => ['model' => SchoolYearService::class, 'method' => 'getSchoolYearJson', 'args' => []],
                    'defaultValues' => [],
                ],
            ],
        ],
    ];
}
