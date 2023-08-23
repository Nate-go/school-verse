<?php

namespace App\Services\ModelServices;
use App\Models\SchoolYear;

class SchoolYearService extends BaseService{
    public function getModel(){
        return SchoolYear::class;
    }
}