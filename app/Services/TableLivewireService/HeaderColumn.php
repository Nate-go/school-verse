<?php

namespace App\Services\TableLivewireService;

class HeaderColumn
{
    public $name;
    public $type;
    public $attributesName;

    public function __construct($name, $attributesName, $type)
    {
        $this->name = $name;
        $this->attributesName = $attributesName;
        $this->type = $type;
    }
}