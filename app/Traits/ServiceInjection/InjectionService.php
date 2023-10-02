<?php

namespace App\Traits\ServiceInjection;

trait InjectionService
{
    public function setInjection($models)
    {
        foreach ($models as $model) {
            $param = lcfirst(class_basename($model));
            $this->$param = app()->make($model);
        }
    }
}
