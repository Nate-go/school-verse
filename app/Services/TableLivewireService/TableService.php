<?php

namespace App\Services\TableLivewireService;

use App\Constant\TableSetting;
use App\Services\UtilService;
use App\Services\ConstantService;


class TableService
{
    private $utilService;

    private $constantService;

    public function __construct(UtilService $utilService, ConstantService $constantService) {
        $this->utilService = $utilService;
        $this->constantService = $constantService;
    }

    public function generateFilterForm($filterForm)
    {
        $filterForm['filterElements'] = $this->filterElemantsGenerate($filterForm['filterElements']);

        return $filterForm;
    }

    private function filterElemantsGenerate($filterElements)
    {
        $newFilterElements = [];
        foreach ($filterElements as $element) {
            $data = $this->generateItem($element['resource']);
            $data = $this->setDefaultFilter($data, $element['defaultValues']);
            $element['resource'] = $data;
            $newFilterElements[] = $element;
        }

        return $newFilterElements;
    }

    private function generateItem($resource)
    {
        $data = $this->utilService->callMethod($resource['model'], $resource['method'], $resource['args']);
        $allItem = [
            'name' => 'All',
            'value' => -1,
        ];
        array_unshift($data, $allItem);

        return $data;
    }

    private function setDefaultFilter($data, $defaultValues)
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

    private function getAllFilterValues($filterElements)
    {
        $allFilterValues = [];
        foreach ($filterElements as $element) {
            $allFilterValues[$element['name']] = $this->getFilterValue($element['resource']);
        }

        return $allFilterValues;
    }

    private function getFilterValue($resource)
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

    private function getFilterData($filterForm)
    {
        $filterData = [];
        $filterData['perPage'] = $filterForm['perPage'];
        $filterData['sort'] = $filterForm['sort'];
        $filterData['filterElements'] = $this->getAllFilterValues($filterForm['filterElements']);
        $filterData['search'] = $filterForm['search'];

        return $filterData;
    }

    public function getHeaderSearch($headers) {
        for($i=0; $i < count($headers); $i++) {
            if($headers[$i]['searchable']) {
                $headers[$i]['searchType'] = $this->getTypeSearch($headers[$i]['searchType']);
            }
        }
        return $headers;
    }

    private function getTypeSearch($types) {
        $searchType = [];
        foreach($types as $type) {
            $name = $this->constantService->getNameConstant(TableSetting::class, $type);
            $searchType[] = ['name' => $name, 'value' => $type];
        }
        return $searchType;
    }

    public function getDataTable($dataSource, $filterForm)
    {
        $filterData = $this->getFilterData($filterForm);
        $data = $this->utilService->callMethod($dataSource['model'], $dataSource['method'], [$filterData]);
        return $data;
    }
}
