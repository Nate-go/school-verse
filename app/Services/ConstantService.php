<?php

namespace App\Services;

use ReflectionClass;

class ConstantService
{
    public function getConstants($constantClass)
    {
        $reflectionClass = new ReflectionClass($constantClass);

        return $reflectionClass->getConstants();
    }

    public function getConstantsJson($constantClass)
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

    public function getNameConstant($constantClass, $value)
    {
        $constants = $this->getConstants($constantClass);
        $key = array_search($value, $constants);

        return $key !== false ? $key : null;
    }

    public function mappingConstant($constantClass, $name, $data)
    {
        foreach ($data as $item) {
            $key = $this->getNameConstant($constantClass, $item->$name);
            if ($key) {
                $item->$name = $key;
            }
        }

        return $data;
    }
}
