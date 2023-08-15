<?php

namespace App\Services;
use DB;
use Illuminate\Support\Facades\Schema;

class BaseService{
    protected $model;

    public function getAll(){
        return $this->model->all();
    }

    public function getById($id){
        return $this->model->where('id', $id)->get();
    }

    public function add($data) {
        $this->model->create($data);
    }

    public function update($id, $data){
        $this->model->where('id', $id)->update($data);
    }

    public function delete($id){
        $this->model->where('id', $id)->delete();
    }
}