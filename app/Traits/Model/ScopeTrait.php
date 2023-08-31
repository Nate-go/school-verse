<?php

namespace App\Traits\Model;

use App\Constant\TableSetting;
use App\Models\SchoolYear;
use Carbon\Carbon;
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
            $query = $query->orderBy($column, $sort['type']);

            return $query;
        }

        return $query;
    }

    public function scopeFilter($query, $columnName, $values) {
        if (empty($values)) {
            return $query;
        }

        return $query->whereIn($columnName, $values);
    }

    public function scopeInSchoolYears($query, $time, $schoolYears) {
        if (empty($schoolYears)) {
            return $query;
        }

        $schoolYears = SchoolYear::whereIn('id', $schoolYears)->get();
        $query->where(false);
        foreach ($schoolYears as $schoolYear) {
            $query->orWhereBetween($time, [$schoolYear->start_at, $schoolYear->end_at]);
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
        return $query->where($column, 'like', '%'.$data.'%');
    }

    public function scopeNormalCompare($query, $column, $type, $data)
    {
        return $query->where($column, $type, $data);
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
