<?php

namespace App\Traits\Model;

use App\Constant\TableSetting;
use App\Models\SchoolYear;
use Schema;

trait ScopeTrait
{
    public function scopeWhereAllDeletedNull($query, $tables) {
        foreach($tables as $table) {
            $query->whereNull($table . '.deleted_at');
        }
    }

    public function scopeWhereOrAll($query, $columns, $values)
    {
        for($i = 0; $i < count($columns); $i++) {
            if($values[$i] != -1) {
                $query->where($columns[$i], $values[$i]);
            }
        }
        return $query;
    }

    public function scopeSelectColumns($query, $columns = ['*'])
    {
        return $query->select($columns);
    }

    public function scopeSort($query, $sort)
    {
        $column = $sort['columnName'];
        if (Schema::hasColumn($this->getTable(), $column)) {
            $query = $query->orderBy($column, $sort['type']);

            return $query;
        }

        return $query;
    }

    public function scopeFilter($query, $filterElements)
    {
        if (empty($filterElements)) {
            return $query;
        }

        foreach ($filterElements as $filterElement) {
            if (! empty($filterElement['values'])) {
                $query->havingRaw($filterElement['column'].' IN ('.implode(',', $filterElement['values']).')');
            }
        }

        return $query;
    }

    public function scopeInSchoolYears($query, $time, $schoolYears)
    {
        if (empty($schoolYears)) {
            return $query;
        }

        $schoolYears = SchoolYear::whereIn('id', $schoolYears)->get();
        $isFirst = true;
        foreach ($schoolYears as $schoolYear) {
            if($isFirst) {
                $query->whereBetween($time, [$schoolYear->start_at, $schoolYear->end_at]);
            } else {
                $query->orWhereBetween($time, [$schoolYear->start_at, $schoolYear->end_at]);
            }
            $isFirst = false;
        }

        return $query;
    }

    public function scopeSearch($query, $search)
    {
        $column = $search['column'];
        $type = $search['type'];
        $data = $search['value'];
        switch ($type) {
            case TableSetting::CONTAIN:
                return $this->scopeContain($query, $column, $data);
            case TableSetting::BETWEEN_NOT_INCLUDE:
                return $this->scopeBetweenNotInclude($query, $column, $data);
            case TableSetting::BETWEEN_INCLUDE:
                return $this->scopeBetweenInclude($query, $column, $data);
            case TableSetting::OUTSIDE_INCLUDE:
                return $this->scopeOutsideInclude($query, $column, $data);
            case TableSetting::OUTSIDE_NOT_INCLUDE:
                return $this->scopeOutsideNotInclude($query, $column, $data);
            default:
                return $this->scopeNormalCompare($query, $column, $type, $data);
        }
    }

    public function scopeContain($query, $column, $data)
    {
        return $query->havingRaw($column." like '%".$data."%'");
    }

    public function scopeNormalCompare($query, $column, $type, $data)
    {
        return $query->havingRaw($column.$type."'%".$data."%'");
    }

    public function scopeBetweenNotInclude($query, $column, $data)
    {
        return $query->where($column, '>', $data[0])->where($column, '<', $data[1]);
    }

    public function scopeBetweenInclude($query, $column, $data)
    {
        return $query->whereIn($column, $data);
    }

    public function scopeOutsideNotInclude($query, $column, $data)
    {
        return $query->where($column, '<', $data[0])->where($column, '>', $data[1]);
    }

    public function scopeOutsideInclude($query, $column, $data)
    {
        return $query->where($column, '<=', $data[0])->where($column, '>=', $data[1]);
    }
}
