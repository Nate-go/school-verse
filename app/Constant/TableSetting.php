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

    const CONTAIN = 'contains';
    const EQUAL = '=';
    const GREATER = '>';
    const SMALLER = '<';
    const GREATER_EQUAL = '>=';
    const SMALLER_EQUAL = '<=';
    const BETWEEN_INCLUDE = '';
    const BETWEEN_NOT_INCLUDE = 'bni';
    const OUTSIDE_INCLUDE = 'osi';
    const OUTSIDE_NOT_INCLUDE = 'osni';

}