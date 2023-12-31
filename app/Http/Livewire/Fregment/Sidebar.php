<?php

namespace App\Http\Livewire\Fregment;

use App\Constant\UserRole;
use App\Http\Livewire\BaseComponent;
use App\Services\UtilService;
use Request;

class Sidebar extends BaseComponent
{
    public $adminRole = UserRole::ADMIN;

    public $teacherRole = UserRole::TEACHER;

    public $studentRole = UserRole::STUDENT;

    public $sidebarIsDisplay = false;

    public $page;

    protected $listeners = ['displaySidebar' => 'changeSidebar'];

    private $utilService;

    public function boot(UtilService $utilService)
    {
        $this->setUp();
    }

    private function setUp()
    {
        $path = Request::path();
        $this->page = explode('/', $path)[0];
    }

    public function render()
    {
        return view('livewire.fregment.sidebar');
    }

    public function changeSidebar()
    {
        $this->sidebarIsDisplay = ! $this->sidebarIsDisplay;
    }
}
