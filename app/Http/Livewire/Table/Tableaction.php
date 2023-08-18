<?php

namespace App\Http\Livewire\Table;

use Livewire\Component;

class Tableaction extends Component
{
    public $filterForm;
    public $selectedCount;

    public function mount($filterForm, $selectedCount) {
        $this->filterForm = $filterForm;
        $this->selectedCount = $selectedCount;
    }
    public function perPageChange($value) {
        $this->filterForm['perPage'] = $value;
        $this->sendDataToParent();
    }

    public function filterValueChange($elementiIndex, $itemIndex)
    {
        $this->filterForm['filterElements'][$elementiIndex]['resource'][$itemIndex]['isSelected'] = !$this->filterForm['filterElements'][$elementiIndex]['resource'][$itemIndex]['isSelected'];
        $this->sendDataToParent();
    }

    public function sendDataToParent()
    {
        $this->emit('dataSent', $this->filterForm);
    }

    public function render()
    {
        return view('livewire.table.tableaction');
    }
}
