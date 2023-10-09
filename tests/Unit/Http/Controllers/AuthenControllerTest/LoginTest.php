<?php

namespace Tests\Unit\Http\Controller\AuthenControllerTest;

use Illuminate\Contracts\View\View;
use App\Http\Controllers\AuthenController;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Tests\Unit\BaseTest;

class LoginTest extends BaseTest
{
    public function testLoginSucessfull()
    {
        $data = $this->setUpInitData();

        $admin = $data['admin'];

        $request = new Request([
            'email' => $admin->email,
            'password' => '123456',
            '_token' => csrf_token(),
        ]);

        $session = new Session();
        $request->setSession($session);

        $athuenController = app()->make(AuthenController::class);
        $result = $athuenController->login($request);

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $result);

        $this->assertEquals(route('homepage'), $result->getTargetUrl());
    }

    public function testLoginFail()
    {
        $request = new Request([
            'email' => 'test@gmail.com',
            'password' => '123456',
        ]);

        $athuenController = app()->make(AuthenController::class);
        $result = $athuenController->login($request);

        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('login', $result->getName());

        $viewData = $result->getData();

        $this->assertEquals('test@gmail.com', $viewData['email']);
        $this->assertEquals(['Login information is incorrect'], $viewData['errors']);
    }
}