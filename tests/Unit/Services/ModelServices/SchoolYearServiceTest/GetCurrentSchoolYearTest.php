<?php

namespace Tests\Unit\Services\ModelServices\SchoolYearServiceTest;

use App\Services\ModelServices\SchoolYearService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\BaseTest;

class GetCurrentSchoolYearTest extends BaseTest
{
    use RefreshDatabase;

    public function testCurrentSchoolYearExist()
    {
        $data = $this->setUpInitData();

        $schoolYear = $data['schoolYear'];

        $schoolYearService = app()->make(SchoolYearService::class);
        $result = $schoolYearService->getCurrentSchoolYear();

        $this->assertEquals($schoolYear->id, $result);
    }

    public function testCurrentSchoolYearNotExist()
    {
        $schoolYearService = app()->make(SchoolYearService::class);
        $result = $schoolYearService->getCurrentSchoolYear();

        $this->assertEquals(null, $result);
    }
}
