<?php

namespace Tests\Unit\Services\ConstantServiceTest;

use App\Constant\SortTypes;
use App\Services\ConstantService;
use Tests\Unit\BaseTest;

class GetNameConstantTest extends BaseTest
{
    public function testExistValue()
    {
        $name = 'DECREASE_SORT';

        $constantService = app()->make(ConstantService::class);
        $result = $constantService->getNameConstant(SortTypes::class, SortTypes::DECREASE_SORT);

        $this->assertEquals($name, $result);
    }

    public function testNotExistValue()
    {
        $constantService = app()->make(ConstantService::class);
        $result = $constantService->getNameConstant(SortTypes::class, 3);

        $this->assertEquals(null, $result);
    }
}
