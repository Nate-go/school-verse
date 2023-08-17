<?php

namespace App\Services\TableLivewireService;
use App\Constant\TableSetting;

class ItemFilter{
    public $name;
    public $value;
    public $status;

    public function __construct($name, $value, $status=TableSetting::NON_SELECTED){
        $this->name = $name;
        $this->value = $value;
        $this->status = $status;
    }
}