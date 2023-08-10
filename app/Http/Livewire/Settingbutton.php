<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Settingbutton extends Component
{
    public $isActive = false;

    public $headerIsLocked = false;

    protected $listeners = ['changeHeaderLock' => 'changeLock'];
    
    public function render()
    {
        return view('livewire.settingbutton');
    }

    public function changeSetting() {
        $this->isActive = !$this->isActive;
    }

    public function changeLock(){
        $this->headerIsLocked = !$this->headerIsLocked;
    }
}
