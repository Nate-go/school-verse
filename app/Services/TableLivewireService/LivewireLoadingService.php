<?php

namespace App\Services\TableLivewireService;

use App\Services\ConstantService;


class LivewireLoadingService
{
    protected static $tableService;

    protected static $constantService;

    public function __construct(TableService $tableService, ConstantService $constantService) {
        self::$tableService = $tableService;
        self::$constantService = $constantService;
    }

    public static function getDataTable($dataSource, $filterForm) {
        return self::$tableService->getDataTable($dataSource, $filterForm);
    }

    public static function getSortType($currentType) {
        return self::$constantService->getSortType($currentType);
    }

    public static function getNameConstant($constantClass, $value)
    {
        return self::$constantService->getNameConstant($constantClass, $value);
    }
}
