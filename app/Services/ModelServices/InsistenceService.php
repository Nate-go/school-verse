<?php

namespace App\Services\ModelServices;
use App\Models\Insistence;

class InsistenceService extends BaseService{
    public function getModel()
    {
        return Insistence::class;
    }
}