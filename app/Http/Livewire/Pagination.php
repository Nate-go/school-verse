<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class Pagination extends Component
{
    use WithPagination;
    public function render()
    {
        return view('livewire.pagination');
    }
}
