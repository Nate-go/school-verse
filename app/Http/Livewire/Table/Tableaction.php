<?php

namespace App\Http\Livewire\Table;

use Livewire\Component;

class Tableaction extends Component
{
    public $filterForm;

    public function mount($filterForm) {
        $this->filterForm = $filterForm;
    }
    public function render()
    {
        return view('livewire.table.tableaction', [
            'filterForm' => $this->filterForm
        ]);
    }
}
