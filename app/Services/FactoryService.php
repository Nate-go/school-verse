<?php

namespace App\Services;

use Exception;
use ReflectionClass;

class FactoryService
{
    public static function calculatePercentage($array, $value)
    {
        $totalCount = count($array);
        if ($totalCount === 0) {
            return 0; // Tránh chia cho 0
        }

        $valueCount = array_count_values($array)[$value] ?? 0;
        $percentage = (($valueCount + 1) / $totalCount) * 100;

        return $percentage;
    }

    public static function isValidPercent($percent, $range){
        if($percent >= $range[0] and $percent <= $range) return true;
    }

    public static function getValidValue($currentValues, $roleRanges, $values){
        do{
            $value = array_rand($values);
        } while (self::isValidPercent(self::calculatePercentage($currentValues, $values), $roleRanges[$value]));
        return $value;
    }
}