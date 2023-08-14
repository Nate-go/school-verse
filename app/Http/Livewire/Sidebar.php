<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Sidebar extends Component
{
    public $sidebarIsDisplay = false;

    protected $listeners = ['displaySidebar' => 'changeSidebar'];

    public function render()
    {
        return view('livewire.sidebar');
    }

    public function changeSidebar(){
        $this->sidebarIsDisplay = !$this->sidebarIsDisplay;
    }
}
