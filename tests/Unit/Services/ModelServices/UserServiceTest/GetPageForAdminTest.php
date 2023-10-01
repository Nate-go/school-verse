<?php

namespace Tests\Unit\Services\ModelServices\UserServiceTest;

use App\Constant\TableData;
use App\Services\ModelServices\UserService;
use App\Services\TableService;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\BaseTest;

class GetPageForAdminTest extends BaseTest
{
    use RefreshDatabase;

    public function testReturnView()
    {
        $userService = app()->make(UserService::class);
        $tableService = app()->make(TableService::class);
        $result = $userService->getPageForAdmin();

        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('admin.user.users', $result->getName());
        $viewData = $result->getData();
        $data = TableData::USERS;
        $tableService->setTableForm($data);
        $this->assertEquals($data, $viewData['userSource']);
    }
}