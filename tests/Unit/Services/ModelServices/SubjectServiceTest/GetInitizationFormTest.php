<?php

namespace Tests\Unit\Services\ModelServices\SubjectServiceTest;

use App\Services\ModelServices\SubjectService;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\BaseTest;

class GetInitizationFormTest extends BaseTest
{
    use RefreshDatabase;

    public function testReturnView()
    {
        $subjectService = app()->make(SubjectService::class);
        $result = $subjectService->getInitizationForm();

        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('admin.subject.subjects-initialization', $result->getName());
    }
}