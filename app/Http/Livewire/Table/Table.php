<?php

namespace App\Http\Livewire\Table;

use App\Constant\TableData;
use App\Constant\TableSetting;
use App\Services\ConstantService;
use App\Services\TableLivewireService\TableService;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;
    public $actionIsOpen = false; 
    public $tableName;
    public $tableHeader;
    public $filterForm;
    public $currentFilterForm;
    public $dataSource;
    public $selectedItems = [];
    protected $listeners = ['dataSent' => 'updateFilterForm', 'filter' => 'updateData'];

    public function mount($tableSource)
    {
        $table = constant(TableData::class . '::' . $tableSource);
        $this->tableName = $table['name'];
        $this->tableHeader = $table['header'];
        $this->filterForm = TableService::generateFilterForm($table['filterForm']);
        $this->currentFilterForm = $this->filterForm;
        $this->dataSource = $table['dataSource'];
    }

    private function updateData() {
        $this->currentFilterForm = $this->filterForm;
    }

    public function render()
    {
        return view('livewire.table.table', [
            'data' => TableService::getDataTable($this->dataSource, $this->currentFilterForm)
        ]);
    }

    public function openAction()
    {
        $this->actionIsOpen = !$this->actionIsOpen;
    }

    public function pageChange($page) {
        $this->selectedItems = [];
        $this->gotoPage($page);
    }

    public function updateFilterForm($filterForm) {
        $this->filterForm = $filterForm;
    }

    public function selectChange($itemId) {
        $index = array_search($itemId, $this->selectedItems);

        if ($index !== false) {
            unset($this->selectedItems[$index]);
        } else {
            $this->selectedItems[] = $itemId;
        }
    }
    public function sort($name, $attributeName) {
        $this->filterForm['sort']['columnName'] = $name;
        $this->filterForm['sort']['displayName'] = $attributeName;
        $this->filterForm['sort']['type'] = ConstantService::getSortType($this->filterForm['sort']['type']);
        $this->filterForm['sort']['displayType'] = ConstantService::getNameConstant(TableSetting::class, $this->filterForm['sort']['type']);
        $this->updateData();
    }
}
