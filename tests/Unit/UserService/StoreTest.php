<?php

namespace Tests\Unit;


use Illuminate\Pagination\LengthAwarePaginator;
use Tests\Unit\UserService\UserTestCase;

class StoreTest extends UserTestCase
{

    public function testNewGetTableData()
    {
        $this->assertArrayHasKey('name', $this->table, "Table has name");

        $this->assertArrayHasKey('header', $this->table, "Table has header");

        $this->assertArrayHasKey('dataSource', $this->table, "Table has data source");

        $this->assertArrayHasKey('filterForm', $this->table, "Table has filter form");
    }
}