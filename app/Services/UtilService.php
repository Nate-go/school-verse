<?php

namespace App\Services;

use App\Models\SchoolYear;
use Carbon\Carbon;
use Exception;
use ReflectionClass;

class UtilService
{
    public function callMethod($className, $methodName, $args = [])
    {
        if (! class_exists($className)) {
            throw new Exception("Class $className does not exist.");
        }

        if (! method_exists($className, $methodName)) {
            throw new Exception("Method $methodName does not exist in class $className.");
        }

        $model = app()->make($className);
        $reflection_class = new ReflectionClass($model);
        $reflection_method = $reflection_class->getMethod($methodName);
        $result = $reflection_method->invokeArgs($model, $args);
        return $result;
    }

    public function randValues($args)
    {
        $index = array_rand($args);

        return $args[$index];
    }

    public function getCurrentSchoolYear() {
        $currentTime = Carbon::now();
        $schoolYear = SchoolYear::where('start_at', '<=', $currentTime)
            ->where('end_at', '>=', $currentTime)
            ->first();
        return $schoolYear->id ?? null;
    }

    public function getJsonData($data) {
        $jsonData = [];
        foreach ($data as $item) {
            $temp = [];
            $temp['name'] = $item->name;
            $temp['value'] = $item->value;
            $jsonData[] = $temp;
        }
        return $jsonData;
    }
}
