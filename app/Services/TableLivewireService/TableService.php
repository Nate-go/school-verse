<?php

namespace App\Services\TableLivewireService;

use App\Services\UtilService;

class TableService
{
    public static function generateFilterForm($filterForm)
    {
        $filterForm['filterElements'] = self::filterElemantsGenerate($filterForm['filterElements']);

        return $filterForm;
    }

    private static function filterElemantsGenerate($filterElements)
    {
        $newFilterElements = [];
        foreach ($filterElements as $element) {
            $data = self::generateItem($element['resource']);
            $data = self::setDefaultFilter($data, $element['defaultValues']);
            $element['resource'] = $data;
            $newFilterElements[] = $element;
        }

        return $newFilterElements;
    }

    private static function generateItem($resource)
    {
        $data = UtilService::callMethod($resource['model'], $resource['method'], $resource['args']);
        $allItem = [
            'name' => 'All',
            'value' => -1,
        ];
        array_unshift($data, $allItem);

        return $data;
    }

    private static function setDefaultFilter($data, $defaultValues)
    {
        $newData = [];
        foreach ($data as $item) {
            if (in_array($item['value'], $defaultValues)) {
                $item['isSelected'] = true;
            } else {
                $item['isSelected'] = false;
            }
            $newData[] = $item;
        }

        return $newData;
    }

    private static function getAllFilterValues($filterElements)
    {
        $allFilterValues = [];
        foreach ($filterElements as $element) {
            $allFilterValues[$element['name']] = self::getFilterValue($element['resource']);
        }

        return $allFilterValues;
    }

    private static function getFilterValue($resource)
    {
        $filterValue = [];
        foreach ($resource as $item) {
            if ($item['isSelected']) {
                if ($item['name'] === 'All') {
                    return [];
                }
                $filterValue[] = $item['value'];
            }
        }

        return $filterValue;
    }

    private static function getFilterData($filterForm)
    {
        $filterData = [];
        $filterData['perPage'] = $filterForm['perPage'];
        $filterData['sort'] = $filterForm['sort'];
        $filterData['filterElements'] = self::getAllFilterValues($filterForm['filterElements']);
        $filterData['search'] = $filterForm['search'];

        return $filterData;
    }

    public static function getDataTable($dataSource, $filterForm)
    {
        $filterData = self::getFilterData($filterForm);
        $data = UtilService::callMethod($dataSource['model'], $dataSource['method'], [$filterData]);

        return $data;
    }
}
