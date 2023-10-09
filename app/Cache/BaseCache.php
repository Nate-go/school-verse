<?php

namespace App\Cache;
use Illuminate\Support\Facades\Redis;

abstract class BaseCache {
    protected $key;
    
    private function set() {
        dd(123);
        Redis::set($this->key, $this->setUpData());
    }

    protected function setUpData() {
        return $this->key;
    }

    final public function get() {
        if(!$this->key) {
            $this->key = $this->getKey();
        }

        $value = Redis::get($this->key);
        if($value) {
            return $this->modifyData($value);
        }

        $this->set();
        return $this->get();
    }

    protected function modifyData($value) {
        return $value;
    }

    protected abstract function getKey();
}