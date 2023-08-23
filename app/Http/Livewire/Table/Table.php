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

    public $search;

    public $currentFilterForm;

    public $dataSource;

    public $types;

    public $selectedItems = [];

    protected $listeners = ['dataSent' => 'updateFilterForm', 'filter' => 'updateData'];

    public function mount($tableSource)
    {
        $table = constant(TableData::class.'::'.$tableSource);
        $this->tableName = $table['name'];
        $this->tableHeader = $table['header'];
        $this->filterForm = TableService::generateFilterForm($table['filterForm']);
        $this->currentFilterForm = $this->filterForm;
        $this->search = $this->filterForm['search'];
        $this->dataSource = $table['dataSource'];
        $this->setTypesSearch();
    }

    public function changeColumnSearch($value)
    {
        $this->search['columnName'] = $value;
        $this->setTypesSearch();
        $this->search['type'] = reset($this->types);
        $this->search['data'] = '';
    }

    public function changeTypeSearch($value)
    {
        $this->search['type'] = $value;
    }

    public function changeData($value)
    {
        if (strpos($value, ',') !== false) {
            $data = explode(',', $value);

            $data = array_map('trim', $data);

            $this->search['data'] = $data;
        } else {
            $this->search['data'] = $value;
        }
        $this->updateData();
    }

    public function setTypesSearch()
    {
        foreach ($this->tableHeader as $column) {
            if ($this->search['columnName'] === $column['attributesName']) {
                $this->types = $column['searchType'];
            }
        }
    }

    public function updateData()
    {
        $this->filterForm['search'] = $this->search;
        $this->currentFilterForm = $this->filterForm;
        $this->gotoPage(1);
    }

    public function render()
    {
        return view('livewire.table.table', [
            'data' => TableService::getDataTable($this->dataSource, $this->currentFilterForm),
        ]);
    }

    public function openAction()
    {
        $this->actionIsOpen = ! $this->actionIsOpen;
    }

    public function pageChange($page)
    {
        $this->selectedItems = [];
        $this->gotoPage($page);
    }

    public function updateFilterForm($filterForm)
    {
        $this->filterForm = $filterForm;
    }

    public function selectChange($itemId)
    {
        $index = array_search($itemId, $this->selectedItems);

        if ($index !== false) {
            unset($this->selectedItems[$index]);
        } else {
            $this->selectedItems[] = $itemId;
        }
    }

    public function sort($name, $attributeName)
    {
        if ($this->filterForm['sort']['columnName'] === $attributeName) {
            $this->filterForm['sort']['type'] = ConstantService::getSortType($this->filterForm['sort']['type']);
        } else {
            $this->filterForm['sort']['columnName'] = $attributeName;
            $this->filterForm['sort']['displayName'] = $name;
            $this->filterForm['sort']['type'] = TableSetting::INCREASE_SORT;
        }
        $this->filterForm['sort']['displayType'] = ConstantService::getNameConstant(TableSetting::class, $this->filterForm['sort']['type']);
        $this->updateData();
    }

    public function selectAll($all)
    {
        $this->selectedItems = $all;
    }

    public function unselectAll()
    {
        $this->selectedItems = [];
    }
}
