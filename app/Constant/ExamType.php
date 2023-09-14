<?php

namespace App\Constant;

class ExamType
{
    const ORAL = 0;

    const FIFTEEN_MINUTES = 1;

    const LESSON = 2;

    const MIDTERM = 3;

    const FINAL_SEMESTER = 4;

    const COEFFICIENT = [
        self::ORAL => 5 / 100,

        self::FIFTEEN_MINUTES => 10 / 100,

        self::LESSON => 15 / 100,

        self::MIDTERM => 20 / 100,

        self::FINAL_SEMESTER => 50 / 100
    ];
}
