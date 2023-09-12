<?php

namespace App\Http\Livewire\Fregment;

use Livewire\Component;

class Userinfomation extends Component
{
    public $userInfoIsOpen = false;

    protected $listeners = [
        'displayUserInfo' => 'changeUserInfo',
        'closeAll' => 'closeInfo',
    ];

    public function closeInfo()
    {
        $this->userInfoIsOpen = false;
    }

    public function render()
    {
        return view('livewire.fregment.userinfomation');
    }

    public function changeUserInfo()
    {
        $this->userInfoIsOpen = ! $this->userInfoIsOpen;
    }
}
