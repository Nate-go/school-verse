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

    public function getAll()
    {
        return $this->model->all();
    }

    public function getById($id)
    {
        return $this->model->find($id);
    }

    public function store($args)
    {
        $this->model->create($args);
    }

    public function update($id, $data)
    {
        $this->model->where('id', $id)->update($data);
    }

    public function delete($id)
    {
        $this->model->where('id', $id)->delete();
    }
}
