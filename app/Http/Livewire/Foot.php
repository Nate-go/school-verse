<?php

namespace App\Http\Livewire;

use App\Models\Notification;


class Foot extends BaseComponent
{
    protected $listeners = [];

    public function render()
    {
        return view('livewire.foot');
    }
}
