<?php

namespace Tests\Unit\UserService;

use App\Constant\TableData;
use App\Services\ModelServices\UserService;
use App\Services\TableLivewireService\TableService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTestCase extends TestCase
{
    //use RefreshDatabase;
    protected $tableService;

    protected $table;

    protected $filterForm;

    protected $userService;

    protected function setUp(): void
    {
        $this->userService = app()->make(UserService::class);

        $this->tableService = app()->make(TableService::class);

        $this->table = TableData::USERS;

        $this->filterForm = $this->tableService->generateFilterForm($this->table['filterForm']);
    }
}
