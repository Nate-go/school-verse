<?php

namespace App\Http\Livewire\Table;

use App\Services\ConstantService;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    public $tableSource;

    public $header;

    public $filterForm;

    public $currentFilterForm;

    public $detailId;

    protected $listeners = ['dataSend' => 'updateFilterForm', 'filter' => 'updateData'];

    protected $constantService;


    public function boot(ConstantService $constantService) {
        $this->constantService = $constantService;
    }

    public function mount($tableSource)
    {
        $this->tableSource = $tableSource;
        $this->header = $tableSource['header'];
        $this->filterForm = $tableSource['filterForm'];
        $this->updateData();
    }

    public function delete($id) {
        
    }

    public function detail($id) {
        $this->detailId = $id;
    }

    public function sort($index) {
        
        if($this->filterForm['sort']['column'] === $index) {
            foreach($this->filterForm['sort']['allTypes'] as $type){
                if($type['value'] !== $this->filterForm['sort']['type']) {
                    $this->filterForm['sort']['type'] = $type['value'];
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
    }

    public function changeData($value)
    {
        $this->filterForm['search']['value']['value'] = $value;
        $this->updateData();
    }

    public function updateFilterForm($filterForm) {
        $this->filterForm['perPage'] = $filterForm['perPage'];
        $this->filterForm['filterElements'] = $filterForm['filterElements'];
    }

    public function updateData() {
        $this->currentFilterForm = $this->filterForm;
        $this->gotoPage(1);
    }

    protected function getData() {

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

    protected function getFilterValues() {
        $filterValue = [];

        $filterValue['perPage'] = $this->currentFilterForm['perPage'];
        $filterValue['search'] = $this->getSearchValue();
        $filterValue['sort'] = $this->getSortValue();
        $filterValue['filters'] = $this->getFilterElements();

        return $filterValue;
    }

    private function getFilterElements() {
        $filters = [];
        $filterElements = $this->currentFilterForm['filterElements'];
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

        $index = $this->currentFilterForm['sort']['column'];
        $column = $this->header[$index]['attributesName'];
        $type = $this->currentFilterForm['sort']['type'];

        return ['column' => $column, 'type' =>$type];
    }

    private function getSearchValue(){

        $searchForm = $this->currentFilterForm['search'];
        $index = $searchForm['value']['element'];
        $column = $this->header[$index]['attributesName'];
        $type = $searchForm['elements'][$index]['types'][$searchForm['value']['type']]['value'];
        $value = $searchForm['value']['value'];

        return ['column' => $column, 'type' => $type, 'value' => $value];
    }
}
