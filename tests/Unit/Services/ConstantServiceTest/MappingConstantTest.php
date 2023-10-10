<?php

namespace Tests\Unit\Services\ConstantServiceTest;

use App\Constant\UserRole;
use App\Models\User;
use App\Services\ConstantService;
use Tests\Unit\BaseTest;

class MappingConstantTest extends BaseTest
{
    public function testMapping()
    {
        $this->setUpInitData();

        $users = User::get();

        $constantService = app()->make(ConstantService::class);
        $users = $constantService->mappingConstant(UserRole::class, 'role', $users);

        foreach ($users as $user) {
            $this->assertTrue(str_contains(strtoupper($user->username), $user->role));
        }
    }
}
