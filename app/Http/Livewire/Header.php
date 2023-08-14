<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Header extends Component
{
    public $headerIsLock = true;
    public $sidebarIsDisplay = false;
    public $isSearching = false;

    public $notifyIsOpen = false;

    public $userInfoIsOpen = false;

    protected $listeners = [
        'changeHeaderLock' => 'changeLock', 
        'displaySidebar' => 'changeSidebar', 
        'displayNotify' => 'changeNotify'
    ];

    public function render()
    {
        return view('livewire.header');
    }

    public function changeLock() {
        $this->headerIsLock = !$this->headerIsLock;
    }

    public function changeSidebar() {
        $this->sidebarIsDisplay = !$this->sidebarIsDisplay;
    }

    public function search() {
        $this->isSearching = !$this->isSearching;
    }

    public function changeNotify()
    {
        $this->notifyIsOpen = !$this->notifyIsOpen;
    }

    
}
