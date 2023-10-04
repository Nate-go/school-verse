<?php

namespace Tests\Unit\Services\UtilServiceTest;

use App\Services\UtilService;
use Tests\Unit\BaseTest;

class FreshStringTest extends BaseTest
{
    public function testFreshString()
    {
        $string = '@test545$%^';
        $expectString = 'test545';
        $utilService = app()->make(UtilService::class);
        $result = $utilService->freshString($string);

        $this->assertEquals($result, $expectString);
    }
}
