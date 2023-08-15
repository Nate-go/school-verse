<?php

namespace App\Services;
use DB;
use Illuminate\Support\Facades\Schema;

class BaseService{
    protected $table;

    public function getAll(){
        $result = DB::table($this->table)->get();
        return $result;
    }

    public function __call($method, $parameters)
    {
        $column = $this->getColumnFromMethod($method);

        if (!$this->isTableHasColumn($column) or count($parameters) !== 1) {
            return null;
        }
        return DB::table($this->table)->where($column, $parameters[0])->get();
    }

    private function getColumnFromMethod($method){
        $method = lcfirst(substr($method, 5));
        $camelCasePattern = '/([a-z])([A-Z])/';
        $snakeCasePattern = '$1_$2';
        $result = preg_replace($camelCasePattern, $snakeCasePattern, $method);
        return strtolower($result);
    }

    private function isTableHasColumn($column){
        return Schema::hasColumn($this->table, $column);
    }
}