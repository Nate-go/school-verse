<?php

namespace Tests\Unit\Http\Controller\SchoolYearControllerTest;

use Illuminate\Contracts\View\View;
use App\Http\Controllers\SchoolYearController;
use Tests\Unit\BaseTest;

class CreateTest extends BaseTest
{
    public function testReturnView()
    {
        $schoolYearController = app()->make(SchoolYearController::class);
        $result = $schoolYearController->create();

        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('admin.school-year.school-years-initialization', $result->getName());
    }
}