<?php

namespace Tests\Unit\Services\ModelServices\GradeServiceTest;

use App\Services\ModelServices\GradeService;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\BaseTest;

class GetInitizationFormTest extends BaseTest
{
    use RefreshDatabase;

    public function testReturnView()
    {
        $gradeService = app()->make(GradeService::class);
        $result = $gradeService->getInitizationForm();

        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('admin.grade.grades-initialization', $result->getName());
    }
}