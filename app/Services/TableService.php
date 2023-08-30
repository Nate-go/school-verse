<?php

namespace App\Services;

use App\Constant\CompareTypes;
use App\Constant\SortTypes;
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

    public function setTableForm(&$tableData) {
        $this->setSearchElementTypes($tableData['filterForm']['search']['elements']);

        $this->setSortAllType($tableData['filterForm']['sort']);

        $this->setResourceFilterElements($tableData['filterForm']['filterElements']);
    }

    private function setSearchElementTypes(&$elements) {
        $types = $this->constantService->getConstantsJson(CompareTypes::class);
        foreach($elements as &$element) {
            foreach($element['types'] as &$elementType) {
                foreach ($types as $type) {
                    if ($elementType === $type['value']) {
                        $elementType = $type;
                    }
                }
            }
        }
    }

    private function setSortAllType(&$sort) {
        $sort['allTypes'] = $this->constantService->getConstantsJson(SortTypes::class);
    }

    private function setResourceFilterElements(&$filterElements) {
        foreach($filterElements as &$filterElement) {
            $this->setResourceItems($filterElement['resource'], $filterElement['defaultValues']);
        }
    }

    private function setResourceItems(&$resource, $defaultValues) {
        $resource = $this->generateItem($resource);
        $this->setDefaultFilterValue($resource, $defaultValues);
    }

    private function generateItem($resource) {
        $data = $this->utilService->callMethod($resource['model'], $resource['method'], $resource['args']);
        $allItem = [
            'name' => 'All',
            'value' => -1,
        ];
        array_unshift($data, $allItem);

        return $data;
    }

    private function setDefaultFilterValue(&$data, $defaultValues)
    {
        foreach ($data as &$item) {
            if (in_array($item['value'], $defaultValues)) {
                $item['isSelected'] = true;
            } else {
                $item['isSelected'] = false;
            }
        }
    }
}
