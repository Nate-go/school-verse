<?php

namespace App\Services;
use DB;
use Illuminate\Support\Facades\Schema;
use ReflectionClass;

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

    public function getConstants($constantClass)
    {
        $reflectionClass = new ReflectionClass($constantClass);
        return $reflectionClass->getConstants();
    }

    public function getNameConstant($constantClass ,$value)
    {
        $constants = $this->getConstants($constantClass);
        $key = array_search($value, $constants);
        return $key !== false ? $key : null;
    }

    public function mappingConstant($constantClass, $name, $data)
    {
        foreach ($data as $item) {
            $key = $this->getNameConstant($constantClass, $item->$name);
            if ($key) {
                $item->$name = $key;
            }
        }
        return $data;
    }
}