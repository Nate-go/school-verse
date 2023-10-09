<?php

namespace Tests\Unit\Http\Controller\InsistenceControllerTest;

use Illuminate\Contracts\View\View;
use App\Http\Controllers\InsistenceController;
use Tests\Unit\BaseTest;

class ShowTest extends BaseTest
{
    public function testInsistenceExistForAdmin()
    {
        $data = $this->setUpInitData();
        $admin = $data['admin'];

        $insistence = $data['insistence'];

        $this->be($admin);
        $insistenceController = app()->make(InsistenceController::class);
        $result = $insistenceController->show($insistence->id);

        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('admin.insistence.insistences-detail', $result->getName());
        $viewData = $result->getData();
        $this->assertEquals($insistence->id, $viewData['id']);
    }

    public function testInsistenceNotExistForAdmin()
    {
        $data = $this->setUpInitData();
        $admin = $data['admin'];

        $this->be($admin);
        $insistenceController = app()->make(InsistenceController::class);
        $result = $insistenceController->show(0);

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $result);
        $this->assertEquals(route('notFound'), $result->getTargetUrl());
    }

    public function testTrueUser()
    {
        $data = $this->setUpInitData();

        $insistence = $data['insistence'];
        $student = $data['student'];

        $this->be($student);
        $insistenceController = app()->make(InsistenceController::class);
        $result = $insistenceController->show($insistence->id);

        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('admin.insistence.insistences-detail', $result->getName());
        $viewData = $result->getData();
        $this->assertEquals($insistence->id, $viewData['id']);
    }

    public function testFalseUser()
    {
        $data = $this->setUpInitData();

        $insistence = $data['insistence'];
        $teacher = $data['teacher'];

        $this->be($teacher);
        $insistenceController = app()->make(InsistenceController::class);
        $result = $insistenceController->show($insistence->id);

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $result);
        $this->assertEquals(route('notPermission'), $result->getTargetUrl());
    }
}