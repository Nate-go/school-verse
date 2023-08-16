<?php

namespace App\DTO;
use App\Constant\Table;

class ItemFilter{
    public $name;
    public $value;
    public $status;

    public function __construct($name, $value, $status=Table::NON_SELECTED){
        $this->name = $name;
        $this->value = $value;
        $this->status = $status;
    }
}