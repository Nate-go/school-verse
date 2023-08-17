<?php

namespace App\Services\TableLivewireService;

class Sort{
    public $name;
    public $type;

    public function __construct($name, $type){
        $this->name = $name;
        $this->type = $type;
    }
}