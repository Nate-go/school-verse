<?php

namespace App\Services\TableLivewireService;

class FilterForm
{
    public $sort;
    public $perPage;
    public $elements;

    public function __construct($sort, $perPage, $constants)
    {
        $this->sort = new Sort($sort['name'], $sort['type']);
        $this->perPage = $perPage;
        foreach($constants as $constant){
            $this->elements[] = new ElementFilter($constant['constant'], $constant['defaultValues']);
        }
    }

    public function getFilterSelected() {
        $filterData = [];
        foreach($this->elements as $element) {
            $filterData[$element->name] = $element->getSelectedItem();
        }
        return $filterData;
    }
}