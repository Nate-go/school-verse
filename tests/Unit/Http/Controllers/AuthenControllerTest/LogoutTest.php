<?php

namespace Tests\Unit\Http\Controller\AuthenControllerTest;

use App\Http\Controllers\AuthenController;
use Tests\Unit\BaseTest;

class LogoutTest extends BaseTest
{
    public function testLogoutSuccessFull()
    {
        $data = $this->setUpInitData();

        $admin = $data['admin'];

        $this->be($admin);
        $athuenController = app()->make(AuthenController::class);
        $result = $athuenController->logout();

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $result);

        $this->assertEquals(route('login.index'), $result->getTargetUrl());
    }
}