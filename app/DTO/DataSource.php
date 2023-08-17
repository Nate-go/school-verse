<?php

namespace App\DTO;

use App\Services\BaseService;

class DataSource
{
    public $model;
    public $method;

    public function __construct($model, $method)
    {
        $this->model = $model;
        $this->method = $method;
    }
}