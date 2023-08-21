<?php 

namespace App\Services;
use App\Constant\TableSetting;
use ReflectionClass;

class ConstantService{
    public static function getSortType($currentType) {
        return $currentType === TableSetting::DECREASE_SORT ? TableSetting::INCREASE_SORT : TableSetting::DECREASE_SORT;
    }

    public static function getConstants($constantClass)
    {
        $reflectionClass = new ReflectionClass($constantClass);
        return $reflectionClass->getConstants();
    }

    public static function getConstantsJson($constantClass)
    {
        $reflectionClass = new ReflectionClass($constantClass);
        $constants = [];

        foreach ($reflectionClass->getConstants() as $name => $value) {
            $constants[] = [
                'name' => $name,
                'value' => $value,
            ];
        }
        return $constants;
    }

    public static function getNameConstant($constantClass, $value)
    {
        $constants = self::getConstants($constantClass);
        $key = array_search($value, $constants);
        return $key !== false ? $key : null;
    }

    public static function mappingConstant($constantClass, $name, $data)
    {
        foreach ($data as $item) {
            $key = self::getNameConstant($constantClass, $item->$name);
            if ($key) {
                $item->$name = $key;
            }
        }
        return $data;
    }
}