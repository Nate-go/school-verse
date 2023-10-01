<?php

namespace App\Http\Livewire\Fregment;

use App\Http\Livewire\BaseComponent;

class Settingbutton extends BaseComponent
{
    public $isActive = false;

    public $headerIsLocked = false;

    protected $listeners = [
        'changeHeaderLock' => 'changeLock',
        'scrollToTop' => 'scrollToTop',
        'closeAll' => 'deactive',
    ];

    public function deactive()
    {
        $this->isActive = false;
    }

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
