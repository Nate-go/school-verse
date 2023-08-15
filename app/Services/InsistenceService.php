<?php

namespace App\Services;
use App\Constant\UserRole;
use App\Models\Insistence;
use App\Models\User;

class InsistenceService extends BaseService{
    public function __construct(Insistence $insistence)
    {
        $this->model = $insistence;
    }
}