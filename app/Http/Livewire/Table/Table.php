<?php

namespace App\Http\Livewire\Table;


use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    public $actionIsOpen = false;

    public $tableSource;

    public $header;

    public $filterForm;

    public $searchForm;

    protected $listeners = ['dataSend' => 'updateFilterForm', 'filter' => 'updateData'];

    public function mount($tableSource)
    {
        $this->tableSource = $tableSource;
        $this->header = $tableSource['header'];
        $this->filterForm = $tableSource['filterForm'];
        $this->searchForm = $this->filterForm['search'];
    }

    public function delete($id) {
        
    }

    public function detail($id) {

    }

    public function changeColumnSearch($value)
    {
        
    }

    public function changeTypeSearch($value)
    {

    }

    public function changeData($value)
    {
        
    }

    protected function getData() {

    }

    public function render()
    {
        return view('livewire.table.table', [
            'data' => $this->getData(),
        ]);
    }

    public function openAction()
    {
        $this->actionIsOpen = ! $this->actionIsOpen;
    }

    public function pageChange($page)
    {
        $this->gotoPage($page);
    }

    protected function getFilterValues() {
        $filterValue = [];

        $filterValue['perPage'] = $this->filterForm['perPage'];
        $filterValue['search'] = $this->getSearchValue();
        $filterValue['sort'] = $this->getSortValue();
        $filterValue['filters'] = $this->getFilterElements();

        return $filterValue;
    }

    private function getFilterElements() {
        $filters = [];
        $filterElements = $this->filterForm['filterElements'];
        foreach($filterElements as $filterElement) {
            $filters[$filterElement['name']] = $this->getFilterResources($filterElement['resource']);
        }
        return $filters;
    }

    private function getFilterResources($resources) {
        $values = [];
        foreach($resources as $resource) {
            if($resource['isSelected']) {
                if ($resource['name'] === 'All')
                    return $values;
                $values[] = $resource['value'];
            }
        }
        return $values;
    }

    private function getSortValue() {

        $index = $this->filterForm['sort']['column'];
        $column = $this->header[$index]['attributesName'];
        $type = $this->filterForm['sort']['type'];

        return ['column' => $column, 'type' =>$type];
    }

    private function getSearchValue(){
        $index = $this->searchForm['value']['element'];
        $column = $this->header[$index]['attributesName'];
        $type = $this->searchForm['elements'][$index]['types'][$this->searchForm['value']['type']]['value'];
        $value = $this->searchForm['value']['value'];

        return ['column' => $column, 'type' => $type, 'value' => $value];
    }
}
