<?php

namespace App\Services;
use App\Constant\UserRole;
use App\Models\User;

class InsistenceService extends BaseService{
    public function __construct()
    {
        $this->table = 'insistences';
    }
}