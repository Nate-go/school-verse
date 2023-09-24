<?php

namespace App\Http\Livewire\Fregment;

use App\Constant\UserRole;
use Auth;
use Livewire\Component;

class Userinfomation extends Component
{
    public $userInfoIsOpen = false;

    public $isAdmin;

    protected $listeners = [
        'displayUserInfo' => 'changeUserInfo',
        'closeAll' => 'closeInfo',
    ];

    public function mount() {
        $this->isAdmin = Auth::user()->role == UserRole::ADMIN;
    }

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
