<?php

namespace App\Http\Livewire;

use App\DTO\TableForm;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;
    public $actionIsOpen = false;
    public $tableName;

    public function mount($tableName)
    {
        $this->tableName = $tableName;
    }

    public function render()
    {
        $tableForm = new TableForm(constant('App\Constant\Table::' . $this->tableName));
        return view('livewire.table', [
            'data' => $tableForm->getData(),
            'header' => $tableForm->header,
        ]);
    }

    public function openAction()
    {
        $this->actionIsOpen = !$this->actionIsOpen;
    }
}
