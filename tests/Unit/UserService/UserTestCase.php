<?php

namespace Tests\Unit;

use App\Constant\TableData;
use App\Services\TableLivewireService\TableService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class UserTestCase extends TestCase
{

    use RefreshDatabase;
    protected $tableService;

    protected $table;

    protected $filterForm;

    protected function setUp(): void
    {
        parent::setUp();

        $this->tableService = app()->make(TableService::class);

        $this->table = TableData::USERS;

        $this->filterForm = $this->tableService->generateFilterForm($this->table['filterForm']);

    }

   
}