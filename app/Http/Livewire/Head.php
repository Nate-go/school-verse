<?php

namespace App\Http\Livewire;

use App\Http\Livewire\BaseComponent;

class Head extends BaseComponent
{
    public $name;

    public function mount($name = null)
    {
        $this->name = $name;
    }

    public function render()
    {
        return view('livewire.head');
    }
}
