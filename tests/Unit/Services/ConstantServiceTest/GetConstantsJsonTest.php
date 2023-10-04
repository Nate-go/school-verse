<?php

namespace Tests\Unit\Services\ConstantServiceTest;

use App\Constant\SortTypes;
use App\Services\ConstantService;
use Tests\Unit\BaseTest;

class GetConstantsJsonTest extends BaseTest
{
    public function testReturnJson()
    {
        $jsonData = [
            'DECREASE_SORT' => 'desc',
            'INCREASE_SORT' => 'asc',
        ];

        $constantService = app()->make(ConstantService::class);
        $result = $constantService->getConstants(SortTypes::class);

        $this->assertEquals($jsonData, $result);
    }
}
