<?php

namespace Tests\Unit\Services\UtilServiceTest;

use App\Services\UtilService;
use Tests\Unit\BaseTest;

class RandValuesTest extends BaseTest
{
    public function testGetRandValue()
    {
        $data = [5, 3, 1, 6, 2, 7];

        $utilService = app()->make(UtilService::class);
        $result = $utilService->randValues($data);

        $this->assertTrue(in_array($result, $data));
    }
}
