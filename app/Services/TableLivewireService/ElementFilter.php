<?php

namespace App\Services\TableLivewireService;

use App\Constant\TableSetting;
use App\Services\ConstantService;

class ElementFilter
{
    public $name;
    public $items;

    public function __construct($constantName, $defaultValues)
    {
        $this->items[] = new ItemFilter('ALL', -1);
        $this->name = class_basename($constantName);
        $this->createConstantList($constantName);
        $this->setDefaultValues($defaultValues);
    }

    private function createConstantList($constant) {
        
        $itemfilters = ConstantService::getConstants($constant);
        foreach ($itemfilters as $key => $value) {
            $this->items[] = new ItemFilter($key, $value);
        }
    }

    private function setDefaultValues($defaultValues){
        foreach($this->items as $item){
            if(in_array($item->value, $defaultValues)){
                $item->status = TableSetting::SELECTED;
            }
        }
    }

    public function getSelectedItem() {
        $selectedItems = [];
        foreach($this->items as $item) {
            if($item->status === TableSetting::SELECTED) {
                if($item->name === 'ALL') {
                    return [];
                }
                $selectedItems[] = $item->value;
            }
        }
        return $selectedItems;
    }
}