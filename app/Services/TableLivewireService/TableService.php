<?php

namespace App\Services\TableLivewireService;

class TableService{
    public static function filterElemantsGenerate($filterElements) {
        $resource = [];
        foreach($filterElements as $element){
            $data = self::generateItem($element['resource']);
            $data = self::setDefaultFilter($data, $element['defaultValues']);
            $resource[] = $data;
        }
        return $resource;
    }

    private static function generateItem($resource){
        $data = UtilService::callMethod($resource['model'], $resource['method'], $resource['args']);
        return $data;
    }

    private static function setDefaultFilter($data, $defaultValues) {
        foreach ($data as $item) {
            if(in_array($item['value'], $defaultValues)) {
                $item['isSelected'] = true; 
            } else {
                $item['isSelected'] = false;
            }
        }
        return $data;
    }
}