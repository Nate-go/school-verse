<?php

namespace App\Http\Livewire;

use App\Http\Resources\UserResource;
use App\Services\UserService;
use Livewire\Component;
use Livewire\WithPagination;

class Tableuser extends Component
{
    use WithPagination;
    public $actionIsOpen = false;

    private $userService;

    public function mount(UserService $userService) {
        $this->userService = $userService;
    }

    public function render()
    {
        return view('livewire.tableuser', [
            'users' => $this->userService->getTable()
        ]); 
    }

    public function openAction() {
        $this->actionIsOpen = !$this->actionIsOpen;
    }
}
