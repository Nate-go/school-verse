<?php

namespace Tests\Unit\Services\ModelServices\UserServiceTest;

use App\Services\ModelServices\UserService;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\BaseTest;

class GetInitizationFormTest extends BaseTest
{
    use RefreshDatabase;

    public function testReturnView()
    {
        $userService = app()->make(UserService::class);
        $result = $userService->getInitizationForm();

        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('admin.user.users-initialization', $result->getName());
    }
}
