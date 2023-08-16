<?php

namespace App\DTO;

use App\Services\BaseService;

class FilterForm
{
    public $elements;

    public function __construct($constants)
    {
        foreach($constants as $constant){
            $this->elements[] = new ElementFilter($constant);
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