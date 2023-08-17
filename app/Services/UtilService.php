<?php

namespace App\Services;
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

        $reflection = new ReflectionMethod($className, $methodName);
        if ($reflection->isStatic()) {
            return $className::$methodName(...$args);
        } else {
            $instance = new $className();
            return $instance->$methodName(...$args);
        }
    }
}