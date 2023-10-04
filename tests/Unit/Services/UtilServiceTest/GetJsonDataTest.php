<?php

namespace Tests\Unit\Services\UtilServiceTest;

use App\Models\Grade;
use App\Services\UtilService;
use Tests\Unit\BaseTest;

class GetJsonDataTest extends BaseTest
{
    public function testGetJsonData()
    {
        $this->setUpInitData();
        $grades = Grade::selectColumns(['id as value', 'name'])->get();
        $expectData = [
            ['name' => 10, 'value' => 1],
        ];
        $utilService = app()->make(UtilService::class);
        $result = $utilService->getJsonData($grades);

        $this->assertEquals($result, $expectData);
    }
}
