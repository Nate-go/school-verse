<?php

namespace App\Http\Livewire\Fregment;

use App\Services\UtilService;
use Livewire\Component;
use Request;

class Header extends Component
{
    public $headerIsLock = true;

    public $sidebarIsDisplay = false;

    public $isSearching = false;

    public $notifyIsOpen = false;

    public $userInfoIsOpen = false;

    public $urls;

    protected $listeners = [
        'changeHeaderLock' => 'changeLock',
        'displaySidebar' => 'changeSidebar',
        'displayNotify' => 'changeNotify',
    ];

    protected $utilService;

    public function boot(UtilService $utilService)
    {
        $this->utilService = $utilService;
        $this->setUp();
    }

    private function setUp()
    {
        $path = Request::path();
        $this->urls = $this->utilService->getUrls($path);
    }

    public function render()
    {
        return view('livewire.fregment.header');
    }

    public function changeLock()
    {
        $this->headerIsLock = ! $this->headerIsLock;
    }

    public function changeSidebar()
    {
        $this->sidebarIsDisplay = ! $this->sidebarIsDisplay;
    }

    public function search()
    {
        $this->isSearching = ! $this->isSearching;
    }

    public function changeNotify()
    {
        $this->notifyIsOpen = ! $this->notifyIsOpen;
    }
}
