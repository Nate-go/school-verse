<?php

namespace Tests\Unit\Services\ModelServices\InsistenceServiceTest;

use App\Services\ModelServices\InsistenceService;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\BaseTest;

class GetCreatePageTest extends BaseTest
{
    use RefreshDatabase;

    public function testInsistenceExist()
    {
        $data = $this->setUpInitData();

        $user = $data['student'];

        $insistenceService = app()->make(InsistenceService::class);
        $result = $insistenceService->getCreatePage($user->id);

        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('user.insistences-initialization', $result->getName());
        $viewData = $result->getData();
        $this->assertEquals($user->id, $viewData['userId']);
    }
}