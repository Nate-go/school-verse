<?php

namespace Tests\Unit\Services\TableServiceTest;

use App\Constant\TableData;
use App\Services\TableService;
use Tests\Unit\BaseTest;

class SetTableFormTest extends BaseTest
{
    public function testDataTableTrue()
    {
        $expectData = [
            'name' => 'grades',
            'header' => [
                [
                    'name' => 'name',
                    'attributesName' => 'name',
                    'type' => 0,
                    'sortable' => true,
                ],
                [
                    'name' => 'number of subjects',
                    'attributesName' => 'number_of_subjects',
                    'type' => 0,
                    'sortable' => true,
                ],
                [
                    'name' => 'number of teachers',
                    'attributesName' => 'number_of_teachers',
                    'type' => 0,
                    'sortable' => true,
                ],
            ],
            'filterForm' => [
                'search' => [
                    'elements' => [
                        [
                            'column' => 0,
                            'types' => [
                                [
                                    'name' => 'CONTAIN',
                                    'value' => 'contains',
                                ],
                                [
                                    'name' => 'EQUAL',
                                    'value' => '=',
                                ],
                            ],
                        ],
                    ],
                    'value' => [
                        'element' => 0,
                        'type' => 0,
                        'value' => '',
                    ],
                ],
                'perPage' => 8,
                'sort' => [
                    'column' => 1,
                    'type' => 'asc',
                    'allTypes' => [
                        [
                            'name' => 'DECREASE_SORT',
                            'value' => 'desc',
                        ],
                        [
                            'name' => 'INCREASE_SORT',
                            'value' => 'asc',
                        ],
                    ],
                ],
                'filterElements' => [],
            ],
        ];

        $data = TableData::GRADES;

        $tableService = app()->make(TableService::class);
        $tableService->setTableForm($data);
        $this->assertEquals($expectData, $data);
    }
}
