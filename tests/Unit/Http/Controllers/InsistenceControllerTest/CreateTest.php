<?php

namespace Tests\Unit\Http\Controller\InsistenceControllerTest;

use Illuminate\Contracts\View\View;
use App\Http\Controllers\InsistenceController;
use Tests\Unit\BaseTest;

class CreateTest extends BaseTest
{
    public function testReturnViewForAdmin()
    {
        $data = $this->setUpInitData();
        $admin = $data['admin'];

        $this->be($admin);
        $insistenceController = app()->make(InsistenceController::class);
        $result = $insistenceController->create();

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $result);

        $this->assertEquals(route('notPermission'), $result->getTargetUrl());
    }

    public function testReturnView()
    {
        $data = $this->setUpInitData();

        $user = $data['student'];

        $this->be($user);
        $insistenceController = app()->make(InsistenceController::class);
        $result = $insistenceController->create();

        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('user.insistences-initialization', $result->getName());
        $viewData = $result->getData();
        $this->assertEquals($user->id, $viewData['userId']);
    }
}