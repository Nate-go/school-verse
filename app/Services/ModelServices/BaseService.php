<?php

namespace App\Services\ModelServices;

use App\Services\ConstantService;
use App\Services\TableService;
use App\Services\UtilService;

abstract class BaseService
{
    protected $model;

    protected $utilService;

    protected $constantService;

    protected $tableService;

    public function __construct()
    {
        $this->model = app()->make($this->getModel());
        $this->utilService = app()->make(UtilService::class);
        $this->constantService = app()->make(ConstantService::class);
        $this->tableService = app()->make(TableService::class);
    }

    abstract protected function getModel();
}
