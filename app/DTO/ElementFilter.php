<?php

namespace App\DTO;

use App\Constant\Table;
use App\Services\BaseService;

class ElementFilter
{
    public $name;
    public $items;

    public function __construct($constant)
    {
        $this->items[] = new ItemFilter('ALL', 0, Table::SELECTED);
        $this->name = class_basename($constant);
        $this->createConstantList($constant);
    }

    private function createConstantList($constant) {
        
        $itemfilters = BaseService::getConstants($constant);
        foreach ($itemfilters as $key => $value) {
            $this->items[] = new ItemFilter($key, $value);
        }
    }

    public function getSelectedItem() {
        $selectedItems = [];
        foreach($this->items as $item) {
            if($item->status === Table::SELECTED) {
                if($item->name === 'ALL') {
                    return [];
                }
                $selectedItems[] = $item->value;
            }
        }
        return $selectedItems;
    }
}