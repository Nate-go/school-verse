<?php

namespace App\Traits\ServiceInjection;

use App\Constant\TableSetting;
use App\Services\ConstantService;
use App\Services\FactoryService;
use App\Services\UtilService;
use Schema;

trait InjectionService
{
    public function setInjection($models) {
        foreach($models as $model) {
            $param = lcfirst(class_basename($model));
            $this->$param = app()->make($model);
        }
    }
}