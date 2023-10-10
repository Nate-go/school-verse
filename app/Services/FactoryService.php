<?php

namespace App\Services;

class FactoryService
{
    private $utilService;

    public function __construct(UtilService $utilService)
    {
        $this->utilService = $utilService;
    }

    private function calculatePercentage($array, $value)
    {
        $totalCount = count($array);
        if ($totalCount === 0) {
            return 0;
        }

        $valueCount = 0;
        foreach ($array as $item) {
            if ($item === $value) {
                $valueCount += 1;
            }
        }
        $percentage = (($valueCount + 1) / $totalCount) * 100;

        return $percentage;
    }

    private function isValidPercent($percent, $range)
    {
        if ($percent >= $range[0] and $percent <= $range[1]) {
            return true;
        }
    }

    public function getValidValue($currentValues, $ranges, $values)
    {
        do {
            $value = $this->utilService->randValues($values);
        } while ($this->isValidPercent($this->calculatePercentage($currentValues, $values), $ranges[$value]));

        return $value;
    }

    public function randValues($args)
    {
        $index = array_rand($args);

        return $args[$index];
    }
}
