<?php

namespace App\Constant;
use App\Services\UserService;

class TableSetting{
    const PER_PAGE_DEFAULT = 10;
    const SELECTED = 0;
    const NON_SELECTED = 1;

    const TEXT_TYPE = 0;
    const IMG_TYPE = 1;
    const DEFAULT_VALUE = -1;
    const DECREASE_SORT = 'desc';
    const INCREASE_SORT = 'asc';
}