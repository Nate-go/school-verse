<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Userinfomation extends Component
{
    public $userInfoIsOpen = false;
    
    protected $listeners = [
        'displayUserInfo' => 'changeUserInfo'
    ];
    public function render()
    {
        return view('livewire.userinfomation');
    }

    public function changeUserInfo()
    {
        $this->userInfoIsOpen = !$this->userInfoIsOpen;
    }
}
