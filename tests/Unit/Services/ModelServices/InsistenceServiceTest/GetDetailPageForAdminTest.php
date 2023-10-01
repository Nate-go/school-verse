<?php

namespace Tests\Unit\Services\ModelServices\InsistenceServiceTest;

use App\Services\ModelServices\InsistenceService;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\BaseTest;

class GetDetailPageForAdminTest extends BaseTest
{
    use RefreshDatabase;

    public function testInsistenceExist()
    {
        $data = $this->setUpInitData();

        $insistence = $data['insistence'];

        $insistenceService = app()->make(InsistenceService::class);
        $result = $insistenceService->getDetailPageForAdmin($insistence->id);

        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('admin.insistence.insistences-detail', $result->getName());
        $viewData = $result->getData();
        $this->assertEquals($insistence->id, $viewData['id']);
    }

    public function testInsistenceNotExist()
    {
        $insistenceService = app()->make(InsistenceService::class);
        $result = $insistenceService->getDetailPageForAdmin(0);

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $result);
        $this->assertEquals(route('notFound'), $result->getTargetUrl());
    }
}