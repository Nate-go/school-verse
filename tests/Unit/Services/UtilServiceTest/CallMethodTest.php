<?php

namespace Tests\Unit\Services\UtilServiceTest;

use App\Constant\SortTypes;
use App\Services\ConstantService;
use App\Services\UtilService;
use Tests\Unit\BaseTest;

class CallMethodTest extends BaseTest
{
    public function testCallMethod()
    {
        $constantService = app()->make(ConstantService::class);

        $data = $constantService->getConstants(SortTypes::class);

        $utilService = app()->make(UtilService::class);
        $result = $utilService->callMethod(ConstantService::class, 'getConstants', [SortTypes::class]);

        $this->assertEquals($result, $data);
    }
}
