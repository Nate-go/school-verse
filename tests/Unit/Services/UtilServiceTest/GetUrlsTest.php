<?php

namespace Tests\Unit\Services\UtilServiceTest;

use App\Services\UtilService;
use Tests\Unit\BaseTest;

class GetUrlsTest extends BaseTest
{
    public function testFreshString()
    {
        $path = 'insistences/create';
        $expectData = [
            ['name' => 'insistences', 'url' => '/insistences'],
            ['name' => 'create', 'url' => '/insistences/create'],
        ];
        $utilService = app()->make(UtilService::class);
        $result = $utilService->getUrls($path);

        $this->assertEquals($result, $expectData);
    }
}
