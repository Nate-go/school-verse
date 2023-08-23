<?php

namespace App\Services;

class FactoryService
{
    public static function calculatePercentage($array, $value)
    {
        $totalCount = count($array);
        if ($totalCount === 0) {
            return 0;
        }

        $valueCount = 0;
        foreach($array as $item) {
            if($item === $value) $valueCount += 1;
        }
        $percentage = (($valueCount + 1) / $totalCount) * 100;

        return $percentage;
    }

    public static function isValidPercent($percent, $range){
        if($percent >= $range[0] and $percent <= $range[1]) return true;
    }

    public static function getValidValue($currentValues, $ranges, $values){
        do{
            $value = UtilService::randValues($values);
        } while (self::isValidPercent(self::calculatePercentage($currentValues, $values), $ranges[$value]));
        return $value;
    }
}