<?php

namespace App\DTO;

use App\Services\BaseService;

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