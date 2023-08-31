<?php

namespace App\Http\Livewire\Fregment;

use Livewire\Component;

class Notifytable extends Component
{
    public $notifyIsOpen = false;

    protected $listeners = [
        'displayNotify' => 'changeNotify',
        'closeAll' => 'closeNotify'
    ];

    public function closeNotify() {
        $this->notifyIsOpen = false;
    }

    public function render()
    {
        return view('livewire.fregment.notifytable');
    }

    public function changeNotify()
    {
        $this->notifyIsOpen = ! $this->notifyIsOpen;
    }
}
