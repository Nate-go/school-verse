<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Tableuser extends Component
{
    public $actionIsOpen = false;

    public function render()
    {
        return view('livewire.tableuser');
    }

    public function openAction() {
        $this->actionIsOpen = !$this->actionIsOpen;
    }
}
