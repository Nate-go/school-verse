<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Notifytable extends Component
{
    public $notifyIsOpen = false;
    protected $listeners = ['displayNotify' => 'changeNotify'];

    public function render()
    {
        return view('livewire.notifytable');
    }

    public function changeNotify()
    {
        $this->notifyIsOpen = !$this->notifyIsOpen;
    }
}
