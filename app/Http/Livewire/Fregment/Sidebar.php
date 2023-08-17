<?php

namespace App\Http\Livewire\Fregment;

use Livewire\Component;

class Sidebar extends Component
{
    public $sidebarIsDisplay = false;

    protected $listeners = ['displaySidebar' => 'changeSidebar'];

    public function render()
    {
        return view('livewire.fregment.sidebar');
    }

    public function changeSidebar(){
        $this->sidebarIsDisplay = !$this->sidebarIsDisplay;
    }
}
