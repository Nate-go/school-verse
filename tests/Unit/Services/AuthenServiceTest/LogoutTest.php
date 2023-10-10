<?php

namespace Tests\Unit\Services\AuthenServiceTest;

use App\Services\AuthenService;
use Tests\Unit\BaseTest;

class LogoutTest extends BaseTest
{
    public function testLogoutSuccessFull()
    {
        $data = $this->setUpInitData();

        $admin = $data['admin'];

        $athuenService = app()->make(AuthenService::class);
        $this->be($admin);
        $result = $athuenService->logout();

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $result);

        $this->assertEquals(route('login.index'), $result->getTargetUrl());
    }
}
