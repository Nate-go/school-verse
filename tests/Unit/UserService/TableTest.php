<?php

namespace Tests\Unit;


use Illuminate\Pagination\LengthAwarePaginator;
use Tests\Unit\UserService\UserTestCase;

class TableTest extends UserTestCase
{

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
