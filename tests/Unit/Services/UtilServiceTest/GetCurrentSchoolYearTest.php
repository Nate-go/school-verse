<?php

namespace Tests\Unit\Services\UtilServiceTest;

use App\Services\ModelServices\SchoolYearService;
use Tests\Unit\BaseTest;

class GetCurrentSchoolYearTest extends BaseTest
{
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
