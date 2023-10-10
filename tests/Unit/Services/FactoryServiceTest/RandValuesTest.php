<?php

namespace Tests\Unit\Services\FactoryServiceTest;

use App\Services\FactoryService;
use Tests\Unit\BaseTest;

class RandValuesTest extends BaseTest
{
    public function testGetRandValue()
    {
        $data = [5, 3, 1, 6, 2, 7];

        $factoryService = app()->make(FactoryService::class);
        $result = $factoryService->randValues($data);

        $this->assertTrue(in_array($result, $data));
    }
}
