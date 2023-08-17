<?php

namespace App\Services\TableLivewireService;

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