<?php

namespace App\Services\ModelServices;

abstract class BaseService{
    protected $model;

    public function __construct()
    {
        $this->model = app()->make($this->getModel());
    }

    abstract protected function getModel();

    public function getAll(){
        return $this->model->all();
    }

    public function getById($id){
        return $this->model->find($id);
    }

    public function store($args) {
        $this->model->create($args);
    }

    public function update($id, $data){
        $this->model->where('id', $id)->update($data);
    }

    public function delete($id){
        $this->model->where('id', $id)->delete();
    }
}