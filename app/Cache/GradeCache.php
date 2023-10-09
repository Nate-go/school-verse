<?php

namespace App\Cache;
use App\Models\Grade;

class GradeCache extends BaseCache {
    protected function getKey() {
        return 'grades';
    }

    protected function setUpData() {
        return Grade::all();
    }

    protected function modifyData($value) {
        return $value;
    }

    public function getById($id) {
        $data = json_decode($this->get());

        foreach($data as $item) {
            if($item->id == $id) {
                return $item;
            }
        }
        return null;
    }
}