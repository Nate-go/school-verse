<?php

namespace App\Http\Livewire\Fregment;

use App\Services\UtilService;
use Livewire\Component;
use Request;

class Sidebar extends Component
{
    public $sidebarIsDisplay = false;

    public $page;

    protected $listeners = ['displaySidebar' => 'changeSidebar'];

    private $utilService;

    public function boot(UtilService $utilService) {
        $this->setUp();
    }

    private function setUp() {
        $path = Request::path();
        $this->page = explode('/', $path)[1];
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
