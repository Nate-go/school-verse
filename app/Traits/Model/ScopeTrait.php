<?php

namespace App\Traits\Model;
use Schema;

trait ScopeTrait
{
    public function scopeSelectColumns($query, $columns = ['*'])
    {
        return $query->select($columns);
    }

    public function scopeSort($query, $sort)
    {
        $column = $sort['columnName'];
        if (Schema::hasColumn($this->getTable(), $column)) {
            return $query->orderBy($column, $sort['type'])->get();
        }
        return $query;
    }
}