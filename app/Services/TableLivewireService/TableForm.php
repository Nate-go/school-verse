<?php

namespace App\Services\TableLivewireService;

use ReflectionClass;

class TableForm
{
    public $name;
    public $header;
    public $filterForm;
    public $dataSource;

    public function __construct($dataTable)
    {
        $this->name = $dataTable['name'];        
        $this->createHeader($dataTable['header']);
        $this->filterForm = new FilterForm($dataTable['sort'], $dataTable['perPage'], $dataTable['filterConstants']);
        $this->dataSource = new DataSource($dataTable['dataSource']['model'], $dataTable['dataSource']['method']);
    }

    private function createHeader($header){
        foreach ($header as $column) {
            $this->header[] = new HeaderColumn($column['name'], $column['attributesName'], $column['type']);
        }
    }

    public function getData() {
        $model = app()->make($this->dataSource->model);
        $reflection_class = new ReflectionClass($this->dataSource->model);
        $reflection_method = $reflection_class->getMethod($this->dataSource->method);
        $result = $reflection_method->invokeArgs($model, ['filterData' => $this->filterForm->getFilterSelected()]);
        return $result;
    }
}