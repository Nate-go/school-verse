<?php

namespace App\Services;
use Exception;
use ReflectionClass;
use ReflectionMethod;

class UtilService{
    public static function callMethod($className, $methodName, $args = [])
    {
        if (!class_exists($className)) {
            throw new Exception("Class $className does not exist.");
        }

        if (!method_exists($className, $methodName)) {
            throw new Exception("Method $methodName does not exist in class $className.");
        }

        $model = app()->make($className);
        $reflection_class = new ReflectionClass($model);
        $reflection_method = $reflection_class->getMethod($methodName);
        $result = $reflection_method->invokeArgs($model, $args);
        return $result;
    }

    public static function randValues($args) {
        $index = array_rand($args);
        return $args[$index];
    }
}