<?php

namespace Tests\Unit\Services\ModelServices\SchoolYearServiceTest;

use App\Services\ModelServices\SchoolYearService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\BaseTest;

class GetSchoolYearJsonTest extends BaseTest
{
    use RefreshDatabase;

    public function testReturnView()
    {
        $schoolYearService = app()->make(SchoolYearService::class);
        $result = $schoolYearService->getSchoolYearJson();

        $this->assertIsArray($result);

        foreach ($result as $item) {
            $this->assertArrayHasKey('name', $item);
            $this->assertArrayHasKey('value', $item);
        }
    }
}
