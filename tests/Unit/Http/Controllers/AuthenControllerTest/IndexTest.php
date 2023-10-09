<?php

namespace Tests\Unit\Http\Controller\AuthenControllerTest;

use Illuminate\Contracts\View\View;
use App\Http\Controllers\AuthenController;
use Tests\Unit\BaseTest;

class IndexTest extends BaseTest
{
    public function testIndex()
    {
        $athuenController = app()->make(AuthenController::class);
        $result = $athuenController->index();

        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('login', $result->getName());
    }
}