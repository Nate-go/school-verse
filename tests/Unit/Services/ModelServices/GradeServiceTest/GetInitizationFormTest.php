<?php

namespace Tests\Unit\Services\ModelServices\GradeServiceTest;

use App\Models\Grade;
use App\Services\ModelServices\GradeService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetInitizationTest extends TestCase
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