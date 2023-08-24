<?php

namespace Tests\Unit;

use App\Constant\TableData;
use App\Services\ModelServices\UserService;
use App\Services\TableLivewireService\TableService;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Prompts\Output\ConsoleOutput;
use Nette\Utils\Paginator;
use Tests\TestCase;

class UserTest extends TestCase
{

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

    public function testGetTableData()
    {
        $this->assertArrayHasKey('name', $this->table, "Table has name");

        $this->assertArrayHasKey('header', $this->table, "Table has header");

        $this->assertArrayHasKey('dataSource', $this->table, "Table has data source");

        $this->assertArrayHasKey('filterForm', $this->table, "Table has filter form");

    }

    public function testGenerateFilterForm() 
    {
        $this->assertArrayHasKey('search', $this->filterForm, "Filter form has search");

        $this->assertArrayHasKey('perPage', $this->filterForm, "Filter form has record per page");

        $this->assertArrayHasKey('sort', $this->filterForm, "Filter form has sort");

        $this->assertArrayHasKey('filterElements', $this->filterForm, "Filter form has filter element");

    }

    public function testTableData()
    {
        $data = $this->tableService->getDataTable($this->table['dataSource'], $this->filterForm);
        $this->assertInstanceOf(LengthAwarePaginator::class, $data);
    }
}
