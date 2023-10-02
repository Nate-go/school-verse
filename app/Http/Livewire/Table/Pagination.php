<?php

namespace App\Http\Livewire\Table;

use App\Http\Livewire\BaseComponent;
use Livewire\WithPagination;

class Pagination extends BaseComponent
{
    use WithPagination;

    public function render()
    {
        return view('livewire.table.pagination');
    }
}
