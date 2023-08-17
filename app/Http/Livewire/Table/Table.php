<?php

namespace App\Http\Livewire\Table;

use App\Constant\TableData;
use App\Services\TableLivewireService\TableForm;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;
    public $tableSource;
    public $actionIsOpen = false;
    private $tableForm; 
    public $tableName;
    public $filterForm;

    public function mount($tableSource)
    {
        $this->tableSource = $tableSource;
    }

    public function render()
    {
        $this->tableForm = new TableForm(constant(TableData::class . '::' . $this->tableSource));
        $this->tableName = $this->tableForm->name;
        $this->filterForm = json_encode($this->tableForm->filterForm);
        return view('livewire.table.table', [
            'data' => $this->tableForm->getData(),
            'header' => $this->tableForm->header,
        ]);
    }

    public function openAction()
    {
        $this->actionIsOpen = !$this->actionIsOpen;
    }
}
