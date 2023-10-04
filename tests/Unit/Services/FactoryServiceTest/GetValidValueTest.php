<?php

namespace Tests\Unit\Services\FactoryServiceTest;

use App\Services\FactoryService;
use Tests\Unit\BaseTest;

class GetValidValueTest extends BaseTest
{
    public function testGetValue()
    {
        $statuses = [0, 0, 0, 0, 0, 0, 0, 0, 1];
        $statusRanges = [[20, 35], [65, 80]];

        $factoryService = app()->make(FactoryService::class);
        $result = $factoryService->getValidValue($statuses, $statusRanges, range(0, 1));

        $this->assertTrue(in_array($result, range(0, 1)));
    }
}
