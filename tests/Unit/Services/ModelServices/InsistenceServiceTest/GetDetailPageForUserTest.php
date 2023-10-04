<?php

namespace Tests\Unit\Services\ModelServices\InsistenceServiceTest;

use App\Services\ModelServices\InsistenceService;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\BaseTest;

class GetDetailPageForUserTest extends BaseTest
{
    use RefreshDatabase;

    public function testTrueUser()
    {
        $data = $this->setUpInitData();

        $insistence = $data['insistence'];
        $student = $data['student'];

        $insistenceService = app()->make(InsistenceService::class);
        $this->be($student);
        $result = $insistenceService->getDetailPageForUser($insistence->id);

        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('admin.insistence.insistences-detail', $result->getName());
        $viewData = $result->getData();
        $this->assertEquals($insistence->id, $viewData['id']);
    }

    public function testFalseUser()
    {
        $data = $this->setUpInitData();

        $insistence = $data['insistence'];
        $teacher = $data['teacher'];
        $insistenceService = app()->make(InsistenceService::class);
        $this->be($teacher);
        $result = $insistenceService->getDetailPageForUser($insistence->id);

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $result);
        $this->assertEquals(route('notPermission'), $result->getTargetUrl());
    }
}
