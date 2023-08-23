<?php

namespace App\Http\Livewire\Fregment;

use Livewire\Component;

class Settingbutton extends Component
{
    public $isActive = false;

    public $headerIsLocked = false;

    protected $listeners = ['changeHeaderLock' => 'changeLock', 'scrollToTop' => 'scrollToTop'];

    public function render()
    {
        return view('livewire.fregment.settingbutton');
    }

    public function changeSetting()
    {
        $this->isActive = ! $this->isActive;
    }

    public function changeLock()
    {
        $this->headerIsLocked = ! $this->headerIsLocked;
    }

    public function scrollToTop()
    {
        $this->dispatchBrowserEvent('scrollToTop');
    }
}
