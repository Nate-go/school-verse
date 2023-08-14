<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Tableuser extends Component
{
    use WithPagination;
    public $actionIsOpen = false;

    //public $users;

    public function render()
    {
        //$this->users = User::paginate(5);
        return view('livewire.tableuser', [
            'users' => User::paginate(5)
        ]);
    }

    public function openAction() {
        $this->actionIsOpen = !$this->actionIsOpen;
    }
}
