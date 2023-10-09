<?php

namespace Tests\Unit\Services\ModelServices\SchoolYearServiceTest;

use App\Services\ModelServices\SchoolYearService;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\BaseTest;

class GetInitizationFormTest extends BaseTest
{
    public function testReturnView()
    {
        $schoolYearService = app()->make(SchoolYearService::class);
        $result = $schoolYearService->getInitizationForm();

        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('admin.school-year.school-years-initialization', $result->getName());
    }
}
