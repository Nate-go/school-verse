<?php

namespace App\Http\Livewire\Table;

use App\Http\Livewire\BaseComponent;
use App\Services\ConstantService;
use Livewire\WithPagination;
use Request;

class Table extends BaseComponent
{
    use WithPagination;

    public $tableSource;

    public $header;

    public $filterForm;

    public $currentFilterForm;

    public $detailUrl;

    protected $listeners = ['dataSend' => 'updateFilterForm', 'filter' => 'updateData'];

    protected $constantService;

    public $userId;

    public function boot(ConstantService $constantService)
    {
        $this->constantService = $constantService;
    }

    public function mount($tableSource, $userId = null)
    {
        $this->userId = $userId;
        $this->tableSource = $tableSource;
        $this->header = $tableSource['header'];
        $this->filterForm = $tableSource['filterForm'];
        $this->detailUrl = '/'.Request::path().'/';
        $this->updateData();
    }

    public function delete($id)
    {
        $this->notify('error', 'You do not have permisson to delelete this item');
    }

    public function sort($index)
    {

        if ($this->filterForm['sort']['column'] === $index) {
            foreach ($this->filterForm['sort']['allTypes'] as $type) {
                if ($type['value'] !== $this->filterForm['sort']['type']) {
                    $this->filterForm['sort']['type'] = $type['value'];
                    break;
                }
            }
        }
        $this->filterForm['sort']['column'] = $index;
        $this->updateData();
    }

    public function changeColumnSearch($value)
    {
        $this->filterForm['search']['value']['element'] = intval($value);
        $this->changeTypeSearch(0);
    }

    public function changeTypeSearch($value)
    {
        $this->filterForm['search']['value']['type'] = intval($value);
        $this->updateData();
    }

    public function changeData($value)
    {
        $this->filterForm['search']['value']['value'] = $value;
        $this->updateData();
    }

    public function updateFilterForm($filterForm)
    {
        $this->filterForm['perPage'] = $filterForm['perPage'];
        $this->filterForm['filterElements'] = $filterForm['filterElements'];
    }

    public function updateData()
    {
        $this->currentFilterForm = $this->filterForm;
        $this->gotoPage(1);
    }

    protected function getData()
    {

    }

    public function render()
    {
        return view('livewire.table.table', [
            'data' => $this->getData(),
        ]);
    }

    public function pageChange($page)
    {
        $this->gotoPage($page);
    }

    protected function getFilterValues()
    {
        $filterValue = [];

        $filterValue['perPage'] = $this->currentFilterForm['perPage'];
        $filterValue['search'] = $this->getSearchValue();
        $filterValue['sort'] = $this->getSortValue();
        $filterValue['filters'] = $this->getFilterElements();

        return $filterValue;
    }

    private function getFilterElements()
    {
        $filters = [];
        $filterElements = $this->currentFilterForm['filterElements'];
        foreach ($filterElements as $filterElement) {
            $filters[$filterElement['name']] = $this->getFilterResources($filterElement['resource']);
        }

        return $filters;
    }

    private function getFilterResources($resources)
    {
        $values = [];
        foreach ($resources as $resource) {
            if ($resource['isSelected']) {
                if ($resource['name'] === 'All') {
                    return $values;
                }
                $values[] = $resource['value'];
            }
        }

        return $values;
    }

    private function getSortValue()
    {

        $index = $this->currentFilterForm['sort']['column'];
        $column = $this->header[$index]['attributesName'];
        $type = $this->currentFilterForm['sort']['type'];

        return ['column' => $column, 'type' => $type];
    }

    private function getSearchValue()
    {

        $searchForm = $this->currentFilterForm['search'];
        $index = $searchForm['value']['element'];
        $column = $this->header[$index]['attributesName'];
        $type = -1;
        foreach ($searchForm['elements'] as $element) {
            if ($element['column'] === $index) {
                $type = $element['types'][$searchForm['value']['type']]['value'];
            }
        }
        $value = $searchForm['value']['value'];

        return ['column' => $column, 'type' => $type, 'value' => $value];
    }

    protected function getElementFilters($columns, $valuesList)
    {
        $elements = [];
        for ($i = 0; $i < count($columns); $i++) {
            $elements[] = ['column' => $columns[$i], 'values' => $valuesList[$i]];
        }

        return $elements;
    }
}
